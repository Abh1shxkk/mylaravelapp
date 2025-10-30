@extends('layouts.admin')
@section('title', 'Due List - ' . $supplier->name)
@section('content')
    <style>
        .due-list-header {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .due-list-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .due-list-header-item {
            font-weight: bold;
        }

        .due-list-header-item span {
            color: #0066cc;
            font-weight: bold;
            margin-left: 5px;
        }

        .due-list-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .due-list-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .due-list-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .due-list-table tr:first-child {
            background: #ffcccc;
        }

        .due-list-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .sno-column,
        .date-column,
        .days-column,
        .amount-column {
            text-align: center;
        }

        .footer-row {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-item {
            display: flex;
            gap: 10px;
        }

        .footer-item label {
            font-weight: bold;
            min-width: 120px;
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

        .expiry-due-badge {
            background: #ffcccc;
            color: #cc0000;
            padding: 8px 12px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }

        .remarks-section {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
            min-height: 60px;
        }

        .remarks-title {
            font-weight: bold;
            color: #0066cc;
            margin-bottom: 10px;
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

        .hold-badge {
            background: #ffcccc;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }

        .pagination-section {
            text-align: center;
            margin-top: 20px;
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="due-list-header">
            <div class="due-list-header-row">
                <div>
                    <div class="due-list-header-item">Name: <span>{{ $supplier->name }}</span></div>
                    <div class="due-list-header-item">Code: <span>{{ $supplier->code ?? '-' }}</span></div>
                </div>
                <div style="text-align: right;">
                    <span style="color: #0066cc; font-size: 14px; font-weight: bold;">Press "F5" To Hold</span>
                </div>
            </div>
        </div>

        <!-- Due List Table -->
        <div style="border: 2px solid #000; border-radius: 0; overflow: hidden;">
            <table class="due-list-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sr.No</th>
                        <th style="width: 12%;">Trans No.</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 8%;">Days</th>
                        <th style="width: 10%;">Due Date</th>
                        <th style="width: 8%;">Days</th>
                        <th style="width: 12%;">Tm.Amt.</th>
                        <th style="width: 12%;">Debit</th>
                        <th style="width: 12%;">Credit</th>
                        <th style="width: 8%;">Hold</th>
                        <th style="width: 8%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dues->count() > 0)
                        @php $sno = 1; @endphp
                        @foreach($dues as $due)
                            <tr @if($sno === 1) style="background: #ffcccc;" @endif>
                                <td class="sno-column" style="font-weight: bold;">{{ $sno }}</td>
                                <td style="text-align: center;">{{ $due->trans_no ?? '-' }}</td>
                                <td class="date-column">{{ $due->invoice_date->format('d-M-y') }}</td>
                                <td class="days-column">{{ $due->invoice_date->diffInDays(now()) }}</td>
                                <td class="date-column">{{ $due->due_date->format('d-M-y') }}</td>
                                <td class="days-column">
                                    @if($due->isOverdue())
                                        <span style="color: #cc0000; font-weight: bold;">{{ $due->daysOverdue() }}</span>
                                    @else
                                        {{ $due->due_date->diffInDays(now()) }}
                                    @endif
                                </td>
                                <td class="amount-column">{{ number_format($due->amount_due, 2) }}</td>
                                <td class="amount-column">{{ number_format($due->amount_due, 2) }}</td>
                                <td class="amount-column">{{ number_format($due->amount_paid, 2) }}</td>
                                <td style="text-align: center;">
                                    <div class="hold-badge">-</div>
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#paymentModal{{ $due->id }}" title="Add Payment">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.suppliers.dues.destroy', [$supplier, $due]) }}" 
                                            style="display: inline;" onsubmit="return confirm('Delete this due?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11" class="empty-message">
                                No due entries found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Footer Summary -->
        <div class="footer-row">
            <div style="display: flex; gap: 30px;">
                <div class="footer-item">
                    <label>(Ledger)</label>
                    <span>{{ number_format($totalDue, 2) }} Dr</span>
                </div>
                <div class="footer-item">
                    <label>(D. L.)</label>
                    <span>{{ number_format($totalOutstanding, 2) }} Dr</span>
                </div>
                <div class="footer-item">
                    <label>(Diff.)</label>
                    <span>{{ number_format(0, 2) }}</span>
                </div>
            </div>
            <div>
                <button class="expiry-due-badge" onclick="alert('Expiry Due List')">
                    Expiry Due List
                </button>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-box">
                <label>Total Due</label>
                <span>{{ number_format($totalDue, 2) }}</span>
            </div>
            <div class="summary-box">
                <label>Total Paid</label>
                <span>{{ number_format($totalPaid, 2) }}</span>
            </div>
            <div class="summary-box">
                <label>Outstanding</label>
                <span>{{ number_format($totalOutstanding, 2) }}</span>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="footer-row" style="margin-top: 15px;">
            <div style="display: flex; gap: 30px;">
                <div class="footer-item">
                    <label>GR.No.:</label>
                    <span>-</span>
                </div>
                <div class="footer-item">
                    <label>GR.Date:</label>
                    <span>-</span>
                </div>
                <div class="footer-item">
                    <label>Trans.:</label>
                    <span>-</span>
                </div>
                <div class="footer-item">
                    <label>Case:</label>
                    <span>-</span>
                </div>
            </div>
        </div>

        <!-- Remarks Section -->
        <div class="remarks-section">
            <div class="remarks-title">Remarks:</div>
            <div style="color: #666; font-size: 12px;">
                <!-- Remarks content here -->
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-print"></i> Print (F7)
            </button>
            <a href="{{ route('admin.suppliers.ledger', $supplier) }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-book"></i> Ledger (F10)
            </a>
            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addDueModal">
                <i class="fas fa-plus"></i> Add New (F9)
            </button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-times"></i> Exit
            </a>
        </div>

        <!-- Pagination -->
        @if($dues->hasPages())
            <div class="pagination-section">
                {{ $dues->links() }}
            </div>
        @endif
    </div>

    <!-- Add Due Modal -->
    <div class="modal fade" id="addDueModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Due Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.suppliers.dues.store', $supplier) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Trans No:</label>
                                <input type="text" name="trans_no" placeholder="Optional">
                            </div>
                            <div class="form-group">
                                <label>Invoice Date:</label>
                                <input type="date" name="invoice_date" value="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="form-group">
                                <label>Due Date:</label>
                                <input type="date" name="due_date" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Amount Due:</label>
                                <input type="number" name="amount_due" step="0.01" required placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label>Amount Paid:</label>
                                <input type="number" name="amount_paid" step="0.01" placeholder="0.00">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="grid-column: 1 / -1;">
                                <label>Remarks:</label>
                                <input type="text" name="remarks" placeholder="Optional remarks">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Due</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Modal (for each due) -->
    @foreach($dues as $due)
        <div class="modal fade" id="paymentModal{{ $due->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment - {{ $due->trans_no }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.suppliers.dues.payment', [$supplier, $due]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Outstanding Amount:</label>
                                <input type="text" value="{{ number_format($due->outstanding_amount, 2) }}" readonly 
                                    class="form-control" style="background: #f0f0f0;">
                            </div>
                            <div class="form-group mt-3">
                                <label>Payment Amount:</label>
                                <input type="number" name="amount_paid" step="0.01" required 
                                    placeholder="0.00" max="{{ $due->outstanding_amount }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Record Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        @media print {
            .action-buttons, .modal, .btn-group {
                display: none !important;
            }
        }
    </style>
@endsection
