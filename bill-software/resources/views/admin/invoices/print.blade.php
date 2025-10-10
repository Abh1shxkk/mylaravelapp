<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #000;
            background: white;
        }

        .invoice-container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 8px;
            background: white;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .invoice-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }

        .company-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            gap: 10px;
        }

        .company-info {
            flex: 1;
            font-size: 9px;
            line-height: 1.4;
        }

        .invoice-info {
            flex: 1;
            text-align: right;
            font-size: 9px;
        }

        .invoice-info .amount-box {
            border: 2px solid #000;
            padding: 6px 8px;
            margin-top: 6px;
            background: #000;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
        }

        .parties-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            border: 1px solid #000;
        }

        .billing-details, .shipping-details {
            flex: 1;
            padding: 6px;
            border-right: 1px solid #000;
            font-size: 8px;
            line-height: 1.4;
        }

        .shipping-details {
            border-right: 1px solid #000;
        }

        .transportation-details {
            flex: 1;
            padding: 6px;
            font-size: 8px;
            line-height: 1.4;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 4px;
            text-decoration: underline;
            font-size: 9px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: left;
            vertical-align: middle;
            font-size: 8px;
        }

        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
            padding: 4px 2px;
        }

        .items-table .text-center {
            text-align: center;
        }

        .items-table .text-right {
            text-align: right;
        }

        .hsn-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .hsn-table th,
        .hsn-table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            font-size: 8px;
        }

        .hsn-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 8px;
        }

        .totals-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            gap: 8px;
        }

        .amount-words {
            flex: 2;
            padding: 6px;
            border: 1px solid #000;
            font-size: 8px;
            line-height: 1.4;
        }

        .total-amounts {
            flex: 1;
            border: 1px solid #000;
        }

        .total-amounts table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-amounts td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 8px;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .bank-details {
            flex: 1;
            font-size: 8px;
            line-height: 1.4;
        }

        .signature-section {
            flex: 1;
            text-align: right;
            font-size: 8px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 150px;
            height: 40px;
            margin: 15px 0 8px auto;
        }

        /* Print Actions Styling */
        .print-actions {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        .print-actions .btn {
            width: 120px;
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .print-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                margin: 0;
                padding: 0;
            }
            
            .invoice-container {
                max-width: 100%;
                margin: 0;
                padding: 3px;
            }
            
            @page {
                margin: 10mm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    <!-- Print Actions (No Print) -->
    <div class="print-actions no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <div class="btn-group-vertical">
            <button onclick="window.print()" class="btn btn-primary btn-sm mb-2">
                <i class="bi bi-printer"></i> Print
            </button>
            <button onclick="downloadPDF()" class="btn btn-success btn-sm mb-2">
                <i class="bi bi-download"></i> Download PDF
            </button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">
                <i class="bi bi-x-circle"></i> Close
            </button>
        </div>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="invoice-title">TAX INVOICE</div>
        </div>

        <!-- Company and Invoice Details -->
        <div class="company-details">
            <div class="company-info">
                <strong>{{ $invoice->company_name ?? ($invoice->company ? $invoice->company->name : '') }}</strong><br>
                @if($invoice->company && $invoice->company->short_name)
                ({{ $invoice->company->short_name }})<br>
                @endif
                @if($invoice->company_address || ($invoice->company && $invoice->company->address))
                {{ $invoice->company_address ?? $invoice->company->address }}<br>
                @endif
                @if($invoice->company && $invoice->company->location)
                Location: {{ $invoice->company->location }}<br>
                @endif
                @if($invoice->company_phone || ($invoice->company && $invoice->company->mobile_1))
                Mobile: {{ $invoice->company_phone ?? $invoice->company->mobile_1 }}<br>
                @endif
                @if($invoice->company && $invoice->company->mobile_2)
                Mobile 2: {{ $invoice->company->mobile_2 }}<br>
                @endif
                @if($invoice->company && $invoice->company->telephone)
                Tel: {{ $invoice->company->telephone }}<br>
                @endif
                @if($invoice->company_email || ($invoice->company && $invoice->company->email))
                Email: {{ $invoice->company_email ?? $invoice->company->email }}<br>
                @endif
                @if($invoice->company && $invoice->company->website)
                Website: {{ $invoice->company->website }}<br>
                @endif
                @if($invoice->company && ($invoice->company->contact_person_1 || $invoice->company->contact_person_2))
                Contact: {{ $invoice->company->contact_person_1 }}{{ $invoice->company->contact_person_2 ? ', ' . $invoice->company->contact_person_2 : '' }}<br>
                @endif
                @if($invoice->company_gst || ($invoice->company && $invoice->company->gst_number))
                <strong>GSTIN: {{ $invoice->company_gst ?? $invoice->company->gst_number }}</strong><br>
                @endif
            </div>
            <div class="invoice-info">
                @if($invoice->company && $invoice->company->alter_code)
                <strong>Series: {{ $invoice->company->alter_code }}</strong><br>
                @endif
                <strong>Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($invoice->invoice_date)->format('l') }})</strong><br>
                <strong>Inv. No: {{ $invoice->invoice_number }}</strong><br>
                @if($invoice->due_date)
                <strong>Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</strong><br>
                @endif
                @if($invoice->status)
                <strong>Status: {{ ucfirst($invoice->status) }}</strong><br>
                @endif
                @if($invoice->customer && $invoice->customer->credit_days)
                <strong>Credit Days: {{ $invoice->customer->credit_days }}</strong><br>
                @endif
                <strong>Cash: {{ $invoice->payment_terms === 'cash' ? 'Y' : 'N' }}</strong><br>
                <div class="amount-box">
                    <strong>Invoice Amount: ₹{{ number_format($invoice->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>

        <!-- Billing, Shipping, Transportation Details -->
        <div class="parties-section">
            <div class="billing-details">
                <div class="section-title">Billing Details</div>
                <strong>{{ $invoice->customer_name ?? ($invoice->customer ? $invoice->customer->name : '') }}</strong><br>
                @if($invoice->customer && $invoice->customer->code)
                Code: {{ $invoice->customer->code }}<br>
                @endif
                @if($invoice->customer_address || ($invoice->customer && $invoice->customer->address))
                {{ $invoice->customer_address ?? $invoice->customer->address }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->city)
                City: {{ $invoice->customer->city }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->pin_code)
                PIN: {{ $invoice->customer->pin_code }}<br>
                @endif
                @if($invoice->customer_phone || ($invoice->customer && $invoice->customer->mobile))
                Mobile: {{ $invoice->customer_phone ?? $invoice->customer->mobile }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->telephone_office)
                Office: {{ $invoice->customer->telephone_office }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->telephone_residence)
                Residence: {{ $invoice->customer->telephone_residence }}<br>
                @endif
                @if($invoice->customer_email || ($invoice->customer && $invoice->customer->email))
                Email: {{ $invoice->customer_email ?? $invoice->customer->email }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->contact_person1)
                Contact: {{ $invoice->customer->contact_person1 }}
                @if($invoice->customer->mobile_contact1) ({{ $invoice->customer->mobile_contact1 }})@endif<br>
                @endif
                @if($invoice->customer && $invoice->customer->contact_person2)
                Contact 2: {{ $invoice->customer->contact_person2 }}
                @if($invoice->customer->mobile_contact2) ({{ $invoice->customer->mobile_contact2 }})@endif<br>
                @endif
                @if($invoice->customer && $invoice->customer->pan_number)
                PAN: {{ $invoice->customer->pan_number }}<br>
                @endif
                @if($invoice->customer_gst || ($invoice->customer && $invoice->customer->tax_registration))
                GSTIN: {{ $invoice->customer_gst ?? $invoice->customer->tax_registration }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->dl_number)
                DL No: {{ $invoice->customer->dl_number }}
                @if($invoice->customer->dl_expiry) (Exp: {{ \Carbon\Carbon::parse($invoice->customer->dl_expiry)->format('d/m/Y') }})@endif<br>
                @endif
                @if($invoice->customer && $invoice->customer->food_license)
                Food Lic: {{ $invoice->customer->food_license }}<br>
                @endif
                @if($invoice->customer_state || ($invoice->customer && $invoice->customer->state_name))
                State: {{ $invoice->customer_state ?? $invoice->customer->state_name }}<br>
                @endif
                @if($invoice->customer_state_code || ($invoice->customer && $invoice->customer->state_code))
                State Code: {{ $invoice->customer_state_code ?? $invoice->customer->state_code }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->credit_days)
                Credit Days: {{ $invoice->customer->credit_days }}<br>
                @endif
            </div>
            <div class="shipping-details">
                <div class="section-title">Shipping Details</div>
                <strong>{{ $invoice->customer_name ?? ($invoice->customer ? $invoice->customer->name : '') }}</strong><br>
                @if($invoice->customer_address || ($invoice->customer && $invoice->customer->address))
                {{ $invoice->customer_address ?? $invoice->customer->address }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->city)
                City: {{ $invoice->customer->city }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->pin_code)
                PIN: {{ $invoice->customer->pin_code }}<br>
                @endif
                @if($invoice->customer_state || ($invoice->customer && $invoice->customer->state_name))
                State: {{ $invoice->customer_state ?? $invoice->customer->state_name }}<br>
                @endif
                @if($invoice->customer_state_code || ($invoice->customer && $invoice->customer->state_code))
                State Code: {{ $invoice->customer_state_code ?? $invoice->customer->state_code }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->area_code)
                Area Code: {{ $invoice->customer->area_code }}<br>
                @endif
                @if($invoice->customer && $invoice->customer->route_code)
                Route Code: {{ $invoice->customer->route_code }}<br>
                @endif
            </div>
            <div class="transportation-details">
                <div class="section-title">Transportation Details</div>
                Transportation Mode: Road<br>
                Vehicle No: -<br>
                Date of Supply: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}<br>
                Place of Supply: -<br>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 3%;">#</th>
                    <th style="width: 5%;">Code</th>
                    <th style="width: 15%;">Item Name</th>
                    <th style="width: 6%;">Batch</th>
                    <th style="width: 5%;">Exp</th>
                    <th style="width: 4%;">Qty</th>
                    <th style="width: 4%;">Unit</th>
                    <th style="width: 6%;">Price</th>
                    <th style="width: 5%;">Disc %</th>
                    <th style="width: 6%;">MRP</th>
                    <th style="width: 6%;">Amount</th>
                    <th style="width: 5%;">GST %</th>
                    <th style="width: 6%;">Tax Amt</th>
                    <th style="width: 5%;">Cess %</th>
                    <th style="width: 6%;">Line Total</th>
                    <th style="width: 8%;">Net Amt</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalQty = 0;
                    $totalAmount = 0;
                    $totalGstAmount = 0;
                    $totalNetAmount = 0;
                @endphp
                @forelse($invoice->items as $index => $item)
                    @php
                        $itemAmount = $item->quantity * $item->unit_price;
                        $gstAmount = ($itemAmount * $item->tax_rate) / 100;
                        $netAmount = $itemAmount + $gstAmount;
                        
                        $totalQty += $item->quantity;
                        $totalAmount += $itemAmount;
                        $totalGstAmount += $gstAmount;
                        $totalNetAmount += $netAmount;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $item->item ? $item->item->code : '-' }}</td>
                        <td>
                            {{ $item->product_name }}
                            @if($item->product_description)
                            <br><small style="color: #666;">{{ $item->product_description }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->item ? $item->item->Batchcode : '-' }}</td>
                        <td class="text-center">{{ $item->item && $item->item->Expiry ? \Carbon\Carbon::parse($item->item->Expiry)->format('m/y') : '-' }}</td>
                        <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                        <td class="text-center">{{ $item->unit ?: ($item->item ? $item->item->Unit : 'PCS') }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-center">{{ number_format($item->discount_percent ?? 0, 2) }}%</td>
                        <td class="text-right">{{ $item->item ? number_format($item->item->Mrp ?? 0, 2) : '-' }}</td>
                        <td class="text-right">{{ number_format($itemAmount, 2) }}</td>
                        <td class="text-center">{{ number_format($item->tax_rate, 2) }}%</td>
                        <td class="text-right">{{ number_format($item->tax_amount ?? $gstAmount, 2) }}</td>
                        <td class="text-center">{{ number_format($item->cess_rate ?? ($item->item ? $item->item->GSTCess : 0), 2) }}%</td>
                        <td class="text-right">{{ number_format($item->line_total ?? $netAmount, 2) }}</td>
                        <td class="text-right">{{ number_format($netAmount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" class="text-center">No items found</td>
                    </tr>
                @endforelse
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td class="text-center">Total</td>
                    <td>{{ count($invoice->items) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{ number_format($totalQty, 0) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">₹{{ number_format($totalAmount, 2) }}</td>
                    <td></td>
                    <td class="text-right">₹{{ number_format($totalGstAmount, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td class="text-right">₹{{ number_format($totalNetAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- HSN/SAC Table -->
        <table class="hsn-table">
            <thead>
                <tr>
                    <th>HSN/SAC</th>
                    <th>Taxable Value</th>
                    <th colspan="2">CGST Tax</th>
                    <th colspan="2">SGST Tax</th>
                    <th colspan="2">IGST Tax</th>
                    <th>Total Amount</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Rate (%)</th>
                    <th>Amount</th>
                    <th>Rate (%)</th>
                    <th>Amount</th>
                    <th>Rate (%)</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hsnGroups = [];
                    foreach($invoice->items as $item) {
                        $hsn = $item->hsn_code ?: 'N/A';
                        if (!isset($hsnGroups[$hsn])) {
                            $hsnGroups[$hsn] = [
                                'taxable_value' => 0,
                                'cgst_rate' => $item->cgst_rate ?? ($item->tax_rate / 2),
                                'sgst_rate' => $item->sgst_rate ?? ($item->tax_rate / 2),
                                'igst_rate' => $item->igst_rate ?? 0,
                                'cgst_amount' => 0,
                                'sgst_amount' => 0,
                                'igst_amount' => 0,
                                'total_amount' => 0
                            ];
                        }
                        
                        $itemAmount = $item->quantity * $item->unit_price;
                        $hsnGroups[$hsn]['taxable_value'] += $itemAmount;
                        $hsnGroups[$hsn]['cgst_amount'] += ($itemAmount * $hsnGroups[$hsn]['cgst_rate']) / 100;
                        $hsnGroups[$hsn]['sgst_amount'] += ($itemAmount * $hsnGroups[$hsn]['sgst_rate']) / 100;
                        $hsnGroups[$hsn]['igst_amount'] += ($itemAmount * $hsnGroups[$hsn]['igst_rate']) / 100;
                        $hsnGroups[$hsn]['total_amount'] += $itemAmount + $hsnGroups[$hsn]['cgst_amount'] + $hsnGroups[$hsn]['sgst_amount'] + $hsnGroups[$hsn]['igst_amount'];
                    }
                @endphp
                @foreach($hsnGroups as $hsn => $group)
                    <tr>
                        <td>{{ $hsn }}</td>
                        <td>{{ number_format($group['taxable_value'], 2) }}</td>
                        <td>{{ number_format($group['cgst_rate'], 2) }}</td>
                        <td>{{ number_format($group['cgst_amount'], 2) }}</td>
                        <td>{{ number_format($group['sgst_rate'], 2) }}</td>
                        <td>{{ number_format($group['sgst_amount'], 2) }}</td>
                        <td>{{ number_format($group['igst_rate'], 2) }}</td>
                        <td>{{ number_format($group['igst_amount'], 2) }}</td>
                        <td>{{ number_format($group['total_amount'], 2) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td>Total</td>
                    <td>₹{{ number_format($totalAmount, 2) }}</td>
                    <td></td>
                    <td>₹{{ number_format(array_sum(array_column($hsnGroups, 'cgst_amount')), 2) }}</td>
                    <td></td>
                    <td>₹{{ number_format(array_sum(array_column($hsnGroups, 'sgst_amount')), 2) }}</td>
                    <td></td>
                    <td>₹{{ number_format(array_sum(array_column($hsnGroups, 'igst_amount')), 2) }}</td>
                    <td>₹{{ number_format($totalNetAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <div class="amount-words">
                <strong>Total Amount In Words:</strong><br>
                {{ $amountInWords }}
            </div>
            <div class="total-amounts">
                <table>
                    @if($invoice->subtotal)
                    <tr>
                        <td><strong>Subtotal:</strong></td>
                        <td>₹{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    @endif
                    @if($invoice->discount_amount && $invoice->discount_amount > 0)
                    <tr>
                        <td><strong>Discount:</strong></td>
                        <td>₹{{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Payment Mode:</strong></td>
                        <td>{{ $invoice->payment_terms ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Received Amount:</strong></td>
                        <td>₹{{ number_format($invoice->paid_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Balance Amount:</strong></td>
                        <td>₹{{ number_format($invoice->balance_amount ?? $invoice->total_amount, 2) }}</td>
                    </tr>
                    @if($invoice->currency && $invoice->currency !== 'INR')
                    <tr>
                        <td><strong>Currency:</strong></td>
                        <td>{{ $invoice->currency }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Additional Charges Section (if any) -->
        @if($invoice->notes || $invoice->terms_conditions)
        <div style="border: 1px solid #000; padding: 6px; margin-bottom: 8px; font-size: 8px;">
            @if($invoice->notes)
            <strong>Notes:</strong> {{ $invoice->notes }}<br>
            @endif
            @if($invoice->terms_conditions)
            <strong>Terms & Conditions:</strong> {{ $invoice->terms_conditions }}
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer-section">
            <div class="bank-details">
                <strong style="font-size: 9px;">Bank Details:</strong><br>
                @if($invoice->company)
                    @php
                        // Try to get bank details from company's supplier record if exists
                        $supplier = \App\Models\Supplier::where('name', $invoice->company->name)->first();
                    @endphp
                    @if($supplier && ($supplier->bank || $supplier->account_no || $supplier->ifsc_code))
                        @if($supplier->bank)
                        <strong>Bank Name / Branch:</strong> {{ $supplier->bank }}@if($supplier->branch) / {{ $supplier->branch }}@endif<br>
                        @endif
                        @if($supplier->account_no)
                        <strong>A/C Name:</strong> {{ $invoice->company->name }}<br>
                        <strong>Account No:</strong> {{ $supplier->account_no }}<br>
                        @endif
                        @if($supplier->ifsc_code)
                        <strong>IFSC Code:</strong> {{ $supplier->ifsc_code }}<br>
                        @endif
                    @else
                        <strong>Bank Name / Branch:</strong> -<br>
                        <strong>A/C Name:</strong> {{ $invoice->company->name }}<br>
                        <strong>Account No:</strong> -<br>
                        <strong>IFSC Code:</strong> -<br>
                    @endif
                @else
                    <strong>Bank Name / Branch:</strong> -<br>
                    <strong>A/C Name:</strong> {{ $invoice->company_name }}<br>
                    <strong>Account No:</strong> -<br>
                    <strong>IFSC Code:</strong> -<br>
                @endif
                <strong>UPI (FOR PAYMENTS):</strong> -<br>
                <br>
                <strong style="font-size: 9px;">For: {{ $invoice->company_name ?? ($invoice->company ? $invoice->company->name : '') }}</strong>
            </div>
            <div class="signature-section">
                <strong style="font-size: 9px;">Terms & Conditions</strong><br>
                <span style="font-size: 7px;">{{ $invoice->terms_conditions ?? 'Advance payment is required' }}</span>
                <div class="signature-line"></div>
                <strong>Authorised Signatory</strong><br>
                <span style="font-size: 7px;">For {{ $invoice->company_name ?? ($invoice->company ? $invoice->company->name : '') }}</span>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads (commented out for better UX)
        // window.onload = function() {
        //     window.print();
        // }

        // PDF Download Function
        async function downloadPDF() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm"></i> Generating...';
            button.disabled = true;
            
            try {
                // Hide print actions temporarily
                const printActions = document.querySelector('.print-actions');
                printActions.style.display = 'none';
                
                // Get the invoice container
                const invoiceContainer = document.querySelector('.invoice-container');
                
                // Generate canvas from HTML
                const canvas = await html2canvas(invoiceContainer, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    width: invoiceContainer.scrollWidth,
                    height: invoiceContainer.scrollHeight
                });
                
                // Create PDF
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
                
                // Calculate dimensions
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 295; // A4 height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let heightLeft = imgHeight;
                
                let position = 0;
                
                // Add image to PDF
                const imgData = canvas.toDataURL('image/png');
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                
                // Add new pages if content is longer than one page
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }
                
                // Download the PDF
                pdf.save('Invoice-{{ $invoice->invoice_number }}.pdf');
                
                // Show success message
                button.innerHTML = '<i class="bi bi-check-circle"></i> Downloaded!';
                button.classList.remove('btn-success');
                button.classList.add('btn-success');
                
                // Restore print actions
                printActions.style.display = 'block';
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    button.innerHTML = '<i class="bi bi-download"></i> Download PDF';
                    button.disabled = false;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-success');
                }, 2000);
                
            } catch (error) {
                console.error('Error generating PDF:', error);
                
                // Show error state
                button.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error';
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                
                // Restore print actions
                document.querySelector('.print-actions').style.display = 'block';
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-success');
                }, 3000);
                
                alert('Error generating PDF. Please try again or use the print function.');
            }
        }

        // Print function
        function printInvoice() {
            // Hide print actions
            document.querySelector('.print-actions').style.display = 'none';
            
            // Print
            window.print();
            
            // Restore print actions after print dialog
            setTimeout(() => {
                document.querySelector('.print-actions').style.display = 'block';
            }, 1000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printInvoice();
            }
            
            // Ctrl+S for download
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                downloadPDF();
            }
            
            // Escape to close
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>
