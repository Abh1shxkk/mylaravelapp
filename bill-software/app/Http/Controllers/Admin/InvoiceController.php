<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $invoices = Invoice::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'overdue') {
                    $query->where('due_date', '<', now())
                        ->where('status', '!=', 'paid');
                } else {
                    $query->where('status', $status);
                }
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('invoice_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('invoice_date', '<=', $dateTo);
            })
            ->latest('invoice_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $companies = Company::where('status', 1)->orderBy('name')->get();
        $customers = Customer::where('status', 1)->orderBy('name')->get();
        $items = Item::where('status', 1)->orderBy('name')->get(); // Only active items

        // Generate next invoice number
        $nextInvoiceNumber = $this->generateInvoiceNumber();

        return view('admin.invoices.create', compact('companies', 'customers', 'items', 'nextInvoiceNumber'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'invoice_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Parse the selected invoice date
                    $invoiceDate = \Carbon\Carbon::parse($value)->startOfDay();

                    // Get SERVER's current date (not user's PC date)
                    $serverToday = \Carbon\Carbon::now()->startOfDay();

                    // Get SERVER's tomorrow date
                    $serverTomorrow = \Carbon\Carbon::now()->addDay()->startOfDay();

                    // Check if invoice date is BEFORE server's today
                    if ($invoiceDate->lt($serverToday)) {
                        $fail('Cannot create bills for previous dates. Only today or tomorrow is allowed.');
                    }

                    // Check if invoice date is AFTER server's tomorrow
                    if ($invoiceDate->gt($serverTomorrow)) {
                        $fail('Cannot create bills for dates beyond tomorrow.');
                    }
                },
            ],
            'items' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $hasValid = collect($value)->filter(function ($row) {
                        $qty = floatval($row['qty'] ?? 0);
                        return $qty > 0 && (!empty($row['item_id']) || !empty($row['product_name'] ?? null));
                    })->count() > 0;
                    if (!$hasValid) {
                        $fail('Add at least one item with quantity greater than 0.');
                    }
                }
            ],
        ]);
        try {
            DB::beginTransaction();

            // Prepare invoice data
            $invoiceData = $request->except(['items']);

            // Generate invoice number (always auto-generate)
            $invoiceData['invoice_number'] = $this->generateInvoiceNumber();

            // Set default status if not provided
            if (empty($invoiceData['status'])) {
                $invoiceData['status'] = 'draft';
            }

            // Set default currency if not provided
            if (empty($invoiceData['currency'])) {
                $invoiceData['currency'] = 'INR';
            }

            // Create the invoice
            $invoice = Invoice::create($invoiceData);

            // Handle invoice items and calculate totals
            $totalSubtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $itemData) {
                    if (!empty($itemData['item_id']) || !empty($itemData['product_name'])) {
                        // Get item details if item_id is provided
                        $item = null;
                        if (!empty($itemData['item_id'])) {
                            $item = Item::find($itemData['item_id']);
                        }

                        // Calculate amounts
                        $quantity = floatval($itemData['qty'] ?? 1);
                        $unitPrice = floatval($itemData['rate'] ?? 0);
                        $discountPercent = floatval($itemData['discount'] ?? 0);
                        $taxRate = floatval($itemData['gst'] ?? 0);

                        $lineTotal = $quantity * $unitPrice;
                        $discountAmount = ($lineTotal * $discountPercent) / 100;
                        $taxableAmount = $lineTotal - $discountAmount;
                        $taxAmount = ($taxableAmount * $taxRate) / 100;
                        $finalAmount = $taxableAmount + $taxAmount;

                        // Accumulate totals
                        $totalSubtotal += $lineTotal;
                        $totalDiscount += $discountAmount;
                        $totalTax += $taxAmount;

                        InvoiceItem::create([
                            'invoice_id' => $invoice->invoice_id,
                            'product_id' => $itemData['item_id'] ?? null,
                            'product_name' => $item->name ?? $itemData['product_name'] ?? 'Custom Item',
                            'product_description' => $itemData['description'] ?? '',
                            'hsn_code' => $itemData['hsn_code'] ?? ($item->hsn_code ?? ''),
                            'quantity' => $quantity,
                            'unit' => $itemData['unit'] ?? ($item->unit ?? 'PCS'),
                            'unit_price' => $unitPrice,
                            'discount_percent' => $discountPercent,
                            'discount_amount' => $discountAmount,
                            'line_total' => $finalAmount,
                            'tax_rate' => $taxRate,
                            'tax_amount' => $taxAmount,
                            'cgst_rate' => $taxRate / 2,
                            'sgst_rate' => $taxRate / 2,
                            'igst_rate' => 0,
                            'cess_rate' => 0
                        ]);
                    }
                }
            }

            // Update invoice with calculated totals
            $invoice->update([
                'subtotal' => $totalSubtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => $totalTax,
                'total_amount' => $totalSubtotal - $totalDiscount + $totalTax,
            ]);

            DB::commit();
            return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['items', 'items.item', 'company', 'customer']);
        $amountInWords = $this->numberToWords(intval($invoice->total_amount)) . ' RUPEES ONLY';
        return view('admin.invoices.show', compact('invoice', 'amountInWords'));
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['items', 'items.item', 'company', 'customer']);
        $amountInWords = $this->numberToWords(intval($invoice->total_amount)) . ' RUPEES ONLY';
        return view('admin.invoices.print', compact('invoice', 'amountInWords'));
    }

    public function edit(Invoice $invoice)
    {
        $companies = Company::where('status', 1)->orderBy('name')->get();
        $customers = Customer::where('status', 1)->orderBy('name')->get();
        $items = Item::where('status', 1)->orderBy('name')->get(); // Only active items

        // Load relationships with eager loading to ensure items are properly loaded
        $invoice->load(['items.item', 'company', 'customer']);
        
        return view('admin.invoices.edit', compact('invoice', 'companies', 'customers', 'items'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:tomorrow'],
            'items' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $hasValid = collect($value)->filter(function ($row) {
                        $qty = floatval($row['qty'] ?? 0);
                        return $qty > 0 && (!empty($row['item_id']) || !empty($row['product_name'] ?? null));
                    })->count() > 0;
                    if (!$hasValid) {
                        $fail('Add at least one item with quantity greater than 0.');
                    }
                }
            ],
        ], [
            'invoice_date.after_or_equal' => 'Cant create bills to the previous day',
        ]);
        try {
            DB::beginTransaction();

            // Update invoice data
            $invoiceData = $request->except(['items']);
            $invoice->update($invoiceData);

            // Delete existing items
            $invoice->items()->delete();

            // Handle invoice items and calculate totals
            $totalSubtotal = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $itemData) {
                    if (!empty($itemData['item_id']) || !empty($itemData['product_name'])) {
                        // Get item details if item_id is provided
                        $item = null;
                        if (!empty($itemData['item_id'])) {
                            $item = Item::find($itemData['item_id']);
                        }

                        // Calculate amounts
                        $quantity = floatval($itemData['qty'] ?? 1);
                        $unitPrice = floatval($itemData['rate'] ?? 0);
                        $discountPercent = floatval($itemData['discount'] ?? 0);
                        $taxRate = floatval($itemData['gst'] ?? 0);

                        $lineTotal = $quantity * $unitPrice;
                        $discountAmount = ($lineTotal * $discountPercent) / 100;
                        $taxableAmount = $lineTotal - $discountAmount;
                        $taxAmount = ($taxableAmount * $taxRate) / 100;
                        $finalAmount = $taxableAmount + $taxAmount;

                        // Accumulate totals
                        $totalSubtotal += $lineTotal;
                        $totalDiscount += $discountAmount;
                        $totalTax += $taxAmount;

                        InvoiceItem::create([
                            'invoice_id' => $invoice->invoice_id,
                            'product_id' => $itemData['item_id'] ?? null,
                            'product_name' => $item->name ?? $itemData['product_name'] ?? 'Custom Item',
                            'product_description' => $itemData['description'] ?? '',
                            'hsn_code' => $itemData['hsn_code'] ?? ($item->hsn_code ?? ''),
                            'quantity' => $quantity,
                            'unit' => $itemData['unit'] ?? ($item->unit ?? 'PCS'),
                            'unit_price' => $unitPrice,
                            'discount_percent' => $discountPercent,
                            'discount_amount' => $discountAmount,
                            'line_total' => $finalAmount,
                            'tax_rate' => $taxRate,
                            'tax_amount' => $taxAmount,
                            'cgst_rate' => $taxRate / 2,
                            'sgst_rate' => $taxRate / 2,
                            'igst_rate' => 0,
                            'cess_rate' => 0
                        ]);
                    }
                }
            }

            // Update invoice with calculated totals
            $invoice->update([
                'subtotal' => $totalSubtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => $totalTax,
                'total_amount' => $totalSubtotal - $totalDiscount + $totalTax,
            ]);

            DB::commit();
            return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Failed to update invoice: ' . $e->getMessage()]);
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            // Delete all invoice items first
            $invoice->items()->delete();

            // Then delete the invoice
            $invoice->delete();

            DB::commit();
            return back()->with('success', 'Invoice deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to delete invoice: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate next invoice number in format: INV-YYYY-XXXX
     * where XXXX is a sequential number starting from 1001
     */
    private function generateInvoiceNumber()
    {
        $year = date('Y');
        $prefix = 'INV-' . $year . '-';

        // Get the last invoice number for this year
        $lastInvoice = Invoice::where('invoice_number', 'LIKE', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            // Extract the number part and increment
            $lastNumber = intval(substr($lastInvoice->invoice_number, strlen($prefix)));
            $nextNumber = $lastNumber + 1;
        } else {
            // Start from 1001 for new year
            $nextNumber = 1001;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Convert number to words (Indian format)
     */
    private function numberToWords($number)
    {
        $ones = array(
            0 => 'ZERO',
            1 => 'ONE',
            2 => 'TWO',
            3 => 'THREE',
            4 => 'FOUR',
            5 => 'FIVE',
            6 => 'SIX',
            7 => 'SEVEN',
            8 => 'EIGHT',
            9 => 'NINE',
            10 => 'TEN',
            11 => 'ELEVEN',
            12 => 'TWELVE',
            13 => 'THIRTEEN',
            14 => 'FOURTEEN',
            15 => 'FIFTEEN',
            16 => 'SIXTEEN',
            17 => 'SEVENTEEN',
            18 => 'EIGHTEEN',
            19 => 'NINETEEN'
        );

        $tens = array(
            2 => 'TWENTY',
            3 => 'THIRTY',
            4 => 'FORTY',
            5 => 'FIFTY',
            6 => 'SIXTY',
            7 => 'SEVENTY',
            8 => 'EIGHTY',
            9 => 'NINETY'
        );

        if ($number < 20) {
            return $ones[$number];
        } elseif ($number < 100) {
            return $tens[intval($number / 10)] . ($number % 10 != 0 ? ' ' . $ones[$number % 10] : '');
        } elseif ($number < 1000) {
            return $ones[intval($number / 100)] . ' HUNDRED' . ($number % 100 != 0 ? ' ' . $this->numberToWords($number % 100) : '');
        } elseif ($number < 100000) {
            return $this->numberToWords(intval($number / 1000)) . ' THOUSAND' . ($number % 1000 != 0 ? ' ' . $this->numberToWords($number % 1000) : '');
        } elseif ($number < 10000000) {
            return $this->numberToWords(intval($number / 100000)) . ' LAKH' . ($number % 100000 != 0 ? ' ' . $this->numberToWords($number % 100000) : '');
        } else {
            return $this->numberToWords(intval($number / 10000000)) . ' CRORE' . ($number % 10000000 != 0 ? ' ' . $this->numberToWords($number % 10000000) : '');
        }
    }
}


