<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\GeneralLedger;
use App\Models\CashBankBook;
use App\Models\SaleLedger;
use App\Models\PurchaseLedger;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AllLedgerController extends Controller
{
    public function index(Request $request)
    {
        $searchField = $request->get('search_field', 'all');
        $searchTerm = $request->get('search', '');
        $ledgerType = $request->get('ledger_type', '');
        $perPage = 10; // Items per page
        $page = $request->get('page', 1);

        // Debug: Log the received parameters
        \Log::info('AllLedger Request Parameters:', [
            'search_field' => $searchField,
            'search' => $searchTerm,
            'ledger_type' => $ledgerType,
            'page' => $page
        ]);

        // Initialize collections
        $customers = collect();
        $suppliers = collect();
        $generalLedgers = collect();
        $cashBankBooks = collect();
        $saleLedgers = collect();
        $purchaseLedgers = collect();

        // Fetch Customers if no ledger type filter or if Customer is selected
        if (!$ledgerType || $ledgerType === 'Customer') {
            $customers = Customer::select('name', 'code', 'opening_balance', 'balance_type', 'address', 'address_line2', 'address_line3', 'mobile', 'email', 'telephone_office', 'telephone_residence', 'fax_number', 'contact_person1', 'contact_person2')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('code', 'like', "%{$searchTerm}%");
                    case 'mobile':
                        return $query->where('mobile', 'like', "%{$searchTerm}%");
                    case 'telephone':
                        return $query->where(function($q) use ($searchTerm) {
                            $q->where('telephone_office', 'like', "%{$searchTerm}%")
                              ->orWhere('telephone_residence', 'like', "%{$searchTerm}%");
                        });
                    case 'address':
                        return $query->where(function($q) use ($searchTerm) {
                            $q->where('address', 'like', "%{$searchTerm}%")
                              ->orWhere('address_line2', 'like', "%{$searchTerm}%")
                              ->orWhere('address_line3', 'like', "%{$searchTerm}%");
                        });
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('code', 'like', "%{$searchTerm}%")
                      ->orWhere('mobile', 'like', "%{$searchTerm}%")
                      ->orWhere('telephone_office', 'like', "%{$searchTerm}%")
                      ->orWhere('telephone_residence', 'like', "%{$searchTerm}%")
                      ->orWhere('address', 'like', "%{$searchTerm}%")
                      ->orWhere('address_line2', 'like', "%{$searchTerm}%")
                      ->orWhere('address_line3', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                $fullAddress = collect([$item->address, $item->address_line2, $item->address_line3])
                    ->filter()
                    ->implode(', ');
                    
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code ?? '-',
                    'ledger_type' => 'Customer',
                    'debit' => $item->balance_type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->balance_type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => $fullAddress ?: '-',
                    'mobile' => $item->mobile ?? '-',
                    'email' => $item->email ?? '-',
                    'telephone' => $item->telephone_office ?? $item->telephone_residence ?? '-',
                    'fax' => $item->fax_number ?? '-',
                    'contact_person1' => $item->contact_person1 ?? '-',
                    'contact_person2' => $item->contact_person2 ?? '-',
                ];
            });
        }

        // Fetch Suppliers if no ledger type filter or if Supplier is selected
        if (!$ledgerType || $ledgerType === 'Supplier') {
            $suppliers = Supplier::select('name', 'code', 'opening_balance', 'opening_balance_type', 'address', 'mobile', 'email', 'telephone')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('code', 'like', "%{$searchTerm}%");
                    case 'mobile':
                        return $query->where('mobile', 'like', "%{$searchTerm}%");
                    case 'telephone':
                        return $query->where('telephone', 'like', "%{$searchTerm}%");
                    case 'address':
                        return $query->where('address', 'like', "%{$searchTerm}%");
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('code', 'like', "%{$searchTerm}%")
                      ->orWhere('mobile', 'like', "%{$searchTerm}%")
                      ->orWhere('telephone', 'like', "%{$searchTerm}%")
                      ->orWhere('address', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code ?? '-',
                    'ledger_type' => 'Supplier',
                    'debit' => $item->opening_balance_type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->opening_balance_type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => $item->address ?? '-',
                    'mobile' => $item->mobile ?? '-',
                    'email' => $item->email ?? '-',
                    'telephone' => $item->telephone ?? '-',
                    'fax' => '-',
                    'contact_person1' => '-',
                    'contact_person2' => '-',
                ];
            });
        }

        // Fetch General Ledger if no ledger type filter or if General Ledger is selected
        if (!$ledgerType || $ledgerType === 'General Ledger') {
            $generalLedgers = GeneralLedger::select('account_name', 'account_code', 'opening_balance', 'balance_type')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('account_name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('account_code', 'like', "%{$searchTerm}%");
                    // Skip mobile, telephone, address for General Ledger as columns don't exist
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('account_name', 'like', "%{$searchTerm}%")
                      ->orWhere('account_code', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->account_name,
                    'code' => $item->account_code ?? '-',
                    'ledger_type' => 'General Ledger',
                    'debit' => $item->balance_type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->balance_type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => '-',
                    'mobile' => '-',
                    'email' => '-',
                    'telephone' => '-',
                    'fax' => '-',
                    'contact_person1' => '-',
                    'contact_person2' => '-',
                ];
            });
        }

        // Fetch Cash/Bank Books if no ledger type filter or if Cash / Bank is selected
        if (!$ledgerType || $ledgerType === 'Cash / Bank') {
            $cashBankBooks = CashBankBook::select('name', 'alter_code', 'opening_balance', 'opening_balance_type', 'address', 'address1', 'account_no')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('alter_code', 'like', "%{$searchTerm}%");
                    case 'address':
                        return $query->where(function($q) use ($searchTerm) {
                            $q->where('address', 'like', "%{$searchTerm}%")
                              ->orWhere('address1', 'like', "%{$searchTerm}%");
                        });
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('alter_code', 'like', "%{$searchTerm}%")
                      ->orWhere('address', 'like', "%{$searchTerm}%")
                      ->orWhere('address1', 'like', "%{$searchTerm}%")
                      ->orWhere('account_no', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                $fullAddress = collect([$item->address, $item->address1])
                    ->filter()
                    ->implode(', ');
                    
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->alter_code ?? '-',
                    'ledger_type' => 'Cash / Bank',
                    'debit' => $item->opening_balance_type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->opening_balance_type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => $fullAddress ?: '-',
                    'mobile' => '-',
                    'email' => '-',
                    'telephone' => '-',
                    'fax' => '-',
                    'contact_person1' => '-',
                    'contact_person2' => '-',
                    'account_no' => $item->account_no ?? '-',
                ];
            });
        }

        // Fetch Sale Ledger if no ledger type filter or if Sale Ledger is selected
        if (!$ledgerType || $ledgerType === 'Sale Ledger') {
            $saleLedgers = SaleLedger::select('ledger_name', 'alter_code', 'opening_balance', 'type')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('ledger_name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('alter_code', 'like', "%{$searchTerm}%");
                    // Skip mobile, telephone, address for Sale Ledger as columns may not exist
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('ledger_name', 'like', "%{$searchTerm}%")
                      ->orWhere('alter_code', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->ledger_name,
                    'code' => $item->alter_code ?? '-',
                    'ledger_type' => 'Sale Ledger',
                    'debit' => $item->type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => '-',
                    'mobile' => '-',
                    'email' => '-',
                    'telephone' => '-',
                    'fax' => '-',
                    'contact_person1' => '-',
                    'contact_person2' => '-',
                ];
            });
        }

        // Fetch Purchase Ledger if no ledger type filter or if Purchase Ledger is selected
        if (!$ledgerType || $ledgerType === 'Purchase Ledger') {
            $purchaseLedgers = PurchaseLedger::select('ledger_name', 'alter_code', 'opening_balance', 'type')
            ->when($searchTerm && $searchField !== 'all', function ($query) use ($searchField, $searchTerm) {
                switch ($searchField) {
                    case 'split_name':
                        return $query->where('ledger_name', 'like', "%{$searchTerm}%");
                    case 'alter_code':
                        return $query->where('alter_code', 'like', "%{$searchTerm}%");
                    // Skip mobile, telephone, address for Purchase Ledger as columns may not exist
                }
            })
            ->when($searchTerm && $searchField === 'all', function ($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('ledger_name', 'like', "%{$searchTerm}%")
                      ->orWhere('alter_code', 'like', "%{$searchTerm}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->ledger_name,
                    'code' => $item->alter_code ?? '-',
                    'ledger_type' => 'Purchase Ledger',
                    'debit' => $item->type === 'D' ? ($item->opening_balance ?? 0) : 0,
                    'credit' => $item->type === 'C' ? ($item->opening_balance ?? 0) : 0,
                    'address' => '-',
                    'mobile' => '-',
                    'email' => '-',
                    'telephone' => '-',
                    'fax' => '-',
                    'contact_person1' => '-',
                    'contact_person2' => '-',
                ];
            });
        }

        // Combine all ledgers
        $allLedgers = collect()
            ->merge($customers)
            ->merge($suppliers)
            ->merge($generalLedgers)
            ->merge($cashBankBooks)
            ->merge($saleLedgers)
            ->merge($purchaseLedgers)
            ->sortBy('name')
            ->values();

        // Implement pagination
        $total = $allLedgers->count();
        $items = $allLedgers->forPage($page, $perPage);
        
        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );

        // For AJAX requests, return only the table content
        if ($request->ajax()) {
            return view('admin.all-ledger.index', compact('paginator'))->render();
        }

        return view('admin.all-ledger.index', compact('paginator'));
    }
}
