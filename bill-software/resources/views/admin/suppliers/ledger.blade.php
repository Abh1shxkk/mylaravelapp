@extends('layouts.admin')
@section('title', 'Ledger - ' . $supplier->name)
@section('content')
    <style>
        .ledger-header {
            background: #ffffcc;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .ledger-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .ledger-header-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ledger-header-item label {
            font-weight: bold;
            min-width: 80px;
        }

        .ledger-header-item input,
        .ledger-header-item select {
            padding: 4px 8px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .ledger-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .ledger-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .opening-balance {
            background: #4169e1;
            color: white;
            font-weight: bold;
        }

        .opening-balance td {
            text-align: center;
        }

        .closing-balance {
            background: #e9ecef;
            font-weight: bold;
        }

        .closing-balance td {
            text-align: center;
        }

        .ledger-footer {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .footer-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 15px;
        }

        .footer-item {
            display: flex;
            gap: 10px;
        }

        .footer-item label {
            font-weight: bold;
            min-width: 150px;
        }

        .footer-item span {
            color: #0066cc;
            font-weight: bold;
        }

        .summary-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .summary-box {
            background: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .summary-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
        }

        .summary-box span {
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }

        .action-buttons {
            background: #fff;
            border: 2px solid #000;
            padding: 10px;
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .action-buttons button,
        .action-buttons a {
            padding: 6px 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .form-section {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-top: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .form-group input,
        .form-group select {
            padding: 6px 8px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .debit-column,
        .credit-column,
        .balance-column {
            text-align: right;
        }

        .transaction-type-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .purchase-badge {
            background: #ffcccc;
            color: #cc0000;
        }

        .return-badge {
            background: #ccffcc;
            color: #00cc00;
        }

        .payment-badge {
            background: #ccccff;
            color: #0000cc;
        }

        .adjustment-badge {
            background: #ffffcc;
            color: #cccc00;
        }
    </style>

    <div class="container-fluid">
        <!-- Header with Date Range -->
        <div class="ledger-header">
            <div class="ledger-header-row">
                <div style="font-weight: bold; font-size: 14px;">{{ $supplier->name }}</div>
                <div class="ledger-header-item">
                    <label>From:</label>
                    <input type="date" id="fromDate" value="{{ $fromDate }}" onchange="updateDateRange()">
                    <button class="btn btn-sm btn-danger" onclick="document.getElementById('fromDate').value='{{ $fromDate }}'">
                        🔴
                    </button>
                </div>
                <div class="ledger-header-item">
                    <label>To:</label>
                    <input type="date" id="toDate" value="{{ $toDate }}" onchange="updateDateRange()">
                    <button class="btn btn-sm btn-danger" onclick="document.getElementById('toDate').value='{{ $toDate }}'">
                        🔴
                    </button>
                </div>
                <div class="ledger-header-item">
                    <label>Filter:</label>
                    <select id="filterType" onchange="updateFilter()">
                        <option value="all" @selected($type === 'all')>All</option>
                        <option value="purchase" @selected($type === 'purchase')>Purchase</option>
                        <option value="return" @selected($type === 'return')>Return</option>
                        <option value="payment" @selected($type === 'payment')>Payment</option>
                        <option value="adjustment" @selected($type === 'adjustment')>Adjustment</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Ledger Table -->
        <div style="border: 2px solid #000; border-radius: 0; overflow: hidden;">
            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Vou. No.</th>
                        <th style="width: 12%;">Date</th>
                        <th style="width: 30%;">Account Name</th>
                        <th style="width: 12%;">Debit</th>
                        <th style="width: 12%;">Credit</th>
                        <th style="width: 12%;">Balance</th>
                        <th style="width: 12%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Opening Balance Row -->
                    <tr class="opening-balance">
                        <td colspan="2"></td>
                        <td>Opening Bal. ( {{ \Carbon\Carbon::parse($fromDate)->format('d-M-y') }} )</td>
                        <td class="debit-column">{{ number_format($supplier->opening_balance ?? 0, 2) }}</td>
                        <td class="credit-column"></td>
                        <td class="balance-column">{{ number_format($supplier->opening_balance ?? 0, 2) }}</td>
                        <td></td>
                    </tr>

                    <!-- Spacer Row -->
                    <tr style="background: #4169e1; height: 20px;">
                        <td colspan="7"></td>
                    </tr>

                    <!-- Ledger Entries -->
                    @if($ledgers->count() > 0)
                        @php
                            $runningBalance = $supplier->opening_balance ?? 0;
                        @endphp
                        @foreach($ledgers as $ledger)
                            @php
                                switch ($ledger->transaction_type) {
                                    case 'Purchase':
                                        $runningBalance += $ledger->amount;
                                        $badgeClass = 'purchase-badge';
                                        break;
                                    case 'Return':
                                        $runningBalance -= $ledger->amount;
                                        $badgeClass = 'return-badge';
                                        break;
                                    case 'Payment':
                                        $runningBalance -= $ledger->amount;
                                        $badgeClass = 'payment-badge';
                                        break;
                                    default:
                                        $runningBalance += $ledger->amount;
                                        $badgeClass = 'adjustment-badge';
                                        break;
                                }
                            @endphp
                            <tr>
                                <td style="text-align: center;">{{ $ledger->trans_no ?? '-' }}</td>
                                <td style="text-align: center;">{{ $ledger->transaction_date->format('d-M-y') }}</td>
                                <td>
                                    <span class="transaction-type-badge {{ $badgeClass }}">
                                        {{ $ledger->transaction_type }}
                                    </span>
                                    @if($ledger->remarks)
                                        <br><small style="color: #666;">{{ $ledger->remarks }}</small>
                                    @endif
                                </td>
                                <td class="debit-column">
                                    @if(in_array($ledger->transaction_type, ['Purchase', 'Adjustment']))
                                        {{ number_format($ledger->amount, 2) }}
                                    @endif
                                </td>
                                <td class="credit-column">
                                    @if(in_array($ledger->transaction_type, ['Return', 'Payment']))
                                        {{ number_format($ledger->amount, 2) }}
                                    @endif
                                </td>
                                <td class="balance-column">{{ number_format($runningBalance, 2) }}</td>
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('admin.suppliers.ledger.destroy', [$supplier, $ledger]) }}" 
                                        style="display: inline;" onsubmit="return confirm('Delete this entry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="empty-message">No ledger entries found for this date range</td>
                        </tr>
                    @endif

                    <!-- Closing Balance Row -->
                    <tr class="closing-balance">
                        <td colspan="2"></td>
                        <td>Closing Bal. ( {{ \Carbon\Carbon::parse($toDate)->format('d-M-y') }} )</td>
                        <td class="debit-column">{{ number_format($totalDebit, 2) }}</td>
                        <td class="credit-column">{{ number_format($totalCredit, 2) }}</td>
                        <td class="balance-column">{{ number_format($runningBalance ?? ($supplier->opening_balance ?? 0), 2) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Summary -->
        <div class="ledger-footer">
            <div class="footer-row">
                <div class="footer-item">
                    <label>Narration:</label>
                    <span>Amendment Mark</span>
                </div>
                <div class="footer-item">
                    <label>Total:</label>
                    <span>{{ number_format($totalDebit, 2) }}</span>
                    <span style="margin-left: 20px;">{{ number_format($totalCredit, 2) }}</span>
                </div>
            </div>

            <div class="summary-section">
                <div class="summary-box">
                    <label>Total Debit</label>
                    <span>{{ number_format($totalDebit, 2) }}</span>
                </div>
                <div class="summary-box">
                    <label>Total Credit</label>
                    <span>{{ number_format($totalCredit, 2) }}</span>
                </div>
                <div class="summary-box">
                    <label>Current Bal.</label>
                    <span>{{ number_format($runningBalance ?? ($supplier->opening_balance ?? 0), 2) }} Dr</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                <i class="fas a-print"></i> Print (F7)
            </button>
            <button class="btn btn-outline-info btn-sm">
                <i class="fas fa-print"></i> Print Summary
            </button>
            <button class="btn btn-outline-warning btn-sm">
                <i class="fas fa-print"></i> Print with Interest (F8)
            </button>
            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addLedgerModal">
                <i class="fas fa-plus"></i> Add New Entry
            </button>
            <a href="{{ route('admin.suppliers.dues', $supplier) }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-list"></i> Due List (F5)
            </a>
            <a href="{{ route('admin.suppliers.pending-orders', $supplier) }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-box"></i> Pending Orders (F7)
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-times"></i> Exit
            </a>
        </div>

        <!-- Pagination -->
        @if($ledgers->hasPages())
            <div style="margin-top: 20px;">
                {{ $ledgers->links() }}
            </div>
        @endif
    </div>

    <!-- Add Ledger Entry Modal -->
    <div class="modal fade" id="addLedgerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Ledger Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.suppliers.ledger.store', $supplier) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Transaction Date:</label>
                                <input type="date" name="transaction_date" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-group">
                                <label>Trans. No:</label>
                                <input type="text" name="trans_no" placeholder="Optional">
                            </div>
                            <div class="form-group">
                                <label>Transaction Type:</label>
                                <select name="transaction_type" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="Purchase">Purchase</option>
                                    <option value="Return">Return</option>
                                    <option value="Payment">Payment</option>
                                    <option value="Adjustment">Adjustment</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Amount:</label>
                                <input type="number" name="amount" step="0.01" required placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label>Remarks:</label>
                                <input type="text" name="remarks" placeholder="Optional remarks">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateDateRange() {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;
            const filterType = document.getElementById('filterType').value;

            const params = new URLSearchParams();
            if (fromDate) params.append('from_date', fromDate);
            if (toDate) params.append('to_date', toDate);
            if (filterType && filterType !== 'all') params.append('type', filterType);

            window.location.href = `{{ route('admin.suppliers.ledger', $supplier) }}?${params.toString()}`;
        }

        function updateFilter() {
            updateDateRange();
        }
    </script>

    <style>
        @media print {
            .ledger-header,
            .action-buttons,
            .modal,
            .btn,
            select,
            input[type="date"] {
                display: none !important;
            }
        }
    </style>
@endsection
