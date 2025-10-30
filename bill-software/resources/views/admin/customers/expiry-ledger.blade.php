@extends('layouts.admin')
@section('title', 'Expiry Ledger - ' . $customer->name)
@section('content')
    <style>
        .expiry-header {
            background: #ffffcc;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .expiry-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .expiry-header-item {
            font-weight: bold;
        }

        .expiry-header-item span {
            color: #0066cc;
            font-weight: bold;
            margin-left: 5px;
        }

        .expiry-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .expiry-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .expiry-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .expiry-table tr:first-child {
            background: #ffcccc;
        }

        .expiry-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .sno-column,
        .date-column,
        .debit-column,
        .credit-column {
            text-align: center;
        }

        .footer-row {
            background: #fff;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            display: flex;
            gap: 30px;
        }

        .footer-item {
            display: flex;
            gap: 10px;
        }

        .footer-item label {
            font-weight: bold;
        }

        .footer-item span {
            color: #0066cc;
            font-weight: bold;
        }

        .adjustment-section {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .adjustment-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .adjustment-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        .adjustment-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .adjustment-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .remarks-section {
            background: #ffccff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
            min-height: 80px;
        }

        .remarks-title {
            font-weight: bold;
            color: #ff0099;
            margin-bottom: 10px;
        }

        .remarks-text {
            font-style: italic;
            color: #ff0099;
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
        .form-group select,
        .form-group textarea {
            padding: 6px 8px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .summary-box {
            background: #ccffcc;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
        }

        .total-records {
            font-weight: bold;
            color: #000;
        }

        .total-amount {
            font-weight: bold;
            color: #0066cc;
        }

        .hold-badge {
            background: #ffcccc;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="expiry-header">
            <div class="expiry-header-row">
                <div class="expiry-header-item">
                    Party: <span>{{ $customer->name }}</span>
                </div>
            </div>
        </div>

        <!-- Main Expiry Table -->
        <div style="border: 2px solid #000; border-radius: 0; overflow: hidden; margin-bottom: 10px;">
            <table class="expiry-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.No.</th>
                        <th style="width: 12%;">Date</th>
                        <th style="width: 15%;">Trn. No.</th>
                        <th style="width: 15%;">Debit</th>
                        <th style="width: 15%;">Credit</th>
                        <th style="width: 30%;">Due/Reference</th>
                        <th style="width: 8%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($ledgers->count() > 0)
                        @php $sno = 1; @endphp
                        @foreach($ledgers as $ledger)
                            <tr @if($sno === 1) style="background: #ffcccc;" @endif>
                                <td class="sno-column">{{ $sno }}</td>
                                <td class="date-column">{{ $ledger->transaction_date->format('d-M-y') }}</td>
                                <td style="text-align: center;">{{ $ledger->trans_no ?? '-' }}</td>
                                <td class="debit-column">
                                    @if(in_array($ledger->transaction_type, ['Sale', 'Adjustment']))
                                        {{ number_format($ledger->amount, 2) }}
                                    @endif
                                </td>
                                <td class="credit-column">
                                    @if(in_array($ledger->transaction_type, ['Return', 'Payment']))
                                        {{ number_format($ledger->amount, 2) }}
                                    @endif
                                </td>
                                <td>{{ $ledger->remarks ?? '-' }}</td>
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('admin.customers.expiry-ledger.destroy', [$customer, $ledger]) }}" 
                                        style="display: inline;" onsubmit="return confirm('Delete this entry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                                No expiry ledger entries found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Footer Summary -->
        <div class="footer-row">
            <div class="footer-left">
                <div class="footer-item">
                    <label>Total Records:</label>
                    <span>{{ $ledgers->count() }}</span>
                </div>
                <div class="footer-item">
                    <label>Debit:</label>
                    <span>{{ number_format($ledgers->where('transaction_type', 'Sale')->sum('amount') + $ledgers->where('transaction_type', 'Adjustment')->sum('amount'), 2) }}</span>
                </div>
                <div class="footer-item">
                    <label>Credit:</label>
                    <span>{{ number_format($ledgers->where('transaction_type', 'Return')->sum('amount') + $ledgers->where('transaction_type', 'Payment')->sum('amount'), 2) }}</span>
                </div>
            </div>
            <div class="footer-item">
                <label>Total Due Amt:</label>
                <span class="summary-box">{{ number_format($ledgers->where('transaction_type', 'Sale')->sum('amount'), 2) }}</span>
            </div>
        </div>

        <!-- Adjustment Section -->
        <div class="adjustment-section">
            <h5 style="margin-top: 0; margin-bottom: 10px;">Adjustments</h5>
            <table class="adjustment-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.No.</th>
                        <th style="width: 15%;">Trn. No.</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 20%;">Amount</th>
                        <th style="width: 45%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $adjustments = $ledgers->where('transaction_type', 'Adjustment');
                    @endphp
                    @if($adjustments->count() > 0)
                        @php $sno = 1; @endphp
                        @foreach($adjustments as $adjustment)
                            <tr>
                                <td style="text-align: center;">{{ $sno }}</td>
                                <td style="text-align: center;">{{ $adjustment->trans_no ?? '-' }}</td>
                                <td style="text-align: center;">{{ $adjustment->transaction_date->format('d-M-y') }}</td>
                                <td style="text-align: right;">{{ number_format($adjustment->amount, 2) }}</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-sm btn-outline-info" title="Edit">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">Delete</button>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 15px; color: #999;">
                                No adjustments
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong>Total Records:</strong>
                    <span style="color: #0066cc; font-weight: bold;">{{ $adjustments->count() }}</span>
                </div>
                <div>
                    <strong>Adjusted Amount:</strong>
                    <span class="summary-box">{{ number_format($adjustments->sum('amount'), 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Remarks Section -->
        <div class="remarks-section">
            <div class="remarks-title">Press " * " To Hold</div>
            <div class="remarks-text">
                <strong>Remarks:</strong><br>
                <textarea style="width: 100%; height: 50px; border: 1px solid #ccc; padding: 5px;" placeholder="Enter remarks here..."></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary">
                <i class="fas fa-print"></i> Print (F7)
            </button>
            <a href="#" class="btn btn-outline-success">
                <i class="fas fa-file-excel"></i> To Excel
            </a>
            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#adjustModal">
                <i class="fas fa-plus"></i> Adjust
            </button>
            <button class="btn btn-outline-warning">
                <i class="fas fa-trash"></i> Delete Adjust
            </button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-danger">
                <i class="fas fa-times"></i> Close
            </a>
        </div>

        <!-- Add Entry Form -->
        <div class="form-section">
            <h5 style="margin-top: 0;">Add New Expiry Ledger Entry</h5>
            <form method="POST" action="{{ route('admin.customers.expiry-ledger.store', $customer) }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Transaction Date:</label>
                        <input type="date" name="transaction_date" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Trn. No:</label>
                        <input type="text" name="trans_no" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label>Transaction Type:</label>
                        <select name="transaction_type" required>
                            <option value="">-- Select Type --</option>
                            <option value="Sale">Sale</option>
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
                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Remarks:</label>
                        <input type="text" name="remarks" placeholder="Optional remarks">
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Entry
                    </button>
                </div>
            </form>
        </div>

        <!-- Pagination -->
        @if($ledgers->hasPages())
            <div style="margin-top: 20px;">
                {{ $ledgers->links() }}
            </div>
        @endif
    </div>

    <!-- Adjust Modal -->
    <div class="modal fade" id="adjustModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Adjustment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.customers.expiry-ledger.store', $customer) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Trn. No:</label>
                            <input type="text" name="trans_no" required placeholder="Transaction number">
                        </div>
                        <div class="form-group mt-3">
                            <label>Date:</label>
                            <input type="date" name="transaction_date" value="{{ now()->toDateString() }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Amount:</label>
                            <input type="number" name="amount" step="0.01" required placeholder="0.00">
                        </div>
                        <input type="hidden" name="transaction_type" value="Adjustment">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Adjustment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .action-buttons, .form-section, .modal {
                display: none !important;
            }
        }
    </style>
@endsection
