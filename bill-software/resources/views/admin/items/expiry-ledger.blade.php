@extends('layouts.admin')
@section('title', 'Expiry Ledger - ' . $item->name)
@section('content')
    <style>
        .ledger-header {
            background: #ffffcc;
            padding: 12px;
            border: 1px solid #dee2e6;
            margin-bottom: 10px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ledger-header-row {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        .ledger-header-item {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .ledger-header-item label {
            font-weight: bold;
            min-width: 80px;
            margin: 0;
        }
        .ledger-header-item input,
        .ledger-header-item select {
            padding: 4px 8px;
            font-size: 12px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
        }
        .adj-history {
            color: #ff6600;
            font-weight: bold;
            font-style: italic;
            font-size: 14px;
        }
        .ledger-table {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }
        .ledger-table th {
            background: #e9ecef;
            padding: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        .ledger-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .ledger-table tr:nth-child(odd) {
            background: #fff;
        }
        .ledger-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .first-row {
            background: #ffcccc !important;
        }
        .ledger-footer {
            background: #ffcccc;
            padding: 12px;
            border: 1px solid #dee2e6;
            margin-top: 10px;
            font-size: 12px;
        }
        .footer-section {
            display: inline-block;
            width: 32%;
            vertical-align: top;
            margin-right: 1%;
        }
        .footer-item {
            margin-bottom: 8px;
            display: flex;
            gap: 8px;
        }
        .footer-item label {
            font-weight: bold;
            min-width: 100px;
        }
        .footer-item input {
            flex: 1;
            padding: 4px 8px;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }
        .total-section {
            background: #ccffcc;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .action-buttons {
            text-align: center;
            margin-top: 10px;
        }
        .action-buttons button,
        .action-buttons a {
            padding: 6px 12px;
            margin: 0 5px;
            font-size: 12px;
        }
        .form-section {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 4px;
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
            border: 1px solid #dee2e6;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="ledger-header">
            <div class="ledger-header-row">
                <div class="ledger-header-item">
                    <label>Item:</label>
                    <strong style="color: #0d6efd;">{{ $item->name }}</strong>
                </div>
            </div>
            <div class="ledger-header-row">
                <div class="ledger-header-item">
                    <label>From:</label>
                    <input type="date" value="{{ $fromDate }}" style="width: 120px;">
                </div>
                <div class="ledger-header-item">
                    <label>To:</label>
                    <input type="date" value="{{ $toDate }}" style="width: 120px;">
                </div>
                <div class="adj-history">Press (F5) Adj.History</div>
                <button class="btn btn-sm btn-primary">Ok</button>
                <button class="btn btn-sm btn-outline-primary">To Excel</button>
                <button class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>

        <!-- Expiry Ledger Table -->
        <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.No.</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 10%;">Trans. No</th>
                        <th style="width: 8%;">Type</th>
                        <th style="width: 20%;">PartyName</th>
                        <th style="width: 10%;">Batch</th>
                        <th style="width: 10%;">Rcvd</th>
                        <th style="width: 10%;">Issued</th>
                        <th style="width: 10%;">Balance</th>
                        <th style="width: 7%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($ledgers->count() > 0)
                        @php $sno = 1; @endphp
                        @foreach($ledgers as $ledger)
                            <tr @if($sno === 1) class="first-row" @endif>
                                <td style="text-align: center; font-weight: bold;">{{ $sno }}</td>
                                <td style="text-align: center;">{{ $ledger->transaction_date->format('d/m/Y') }}</td>
                                <td style="text-align: center;">{{ $ledger->trans_no ?? '-' }}</td>
                                <td style="text-align: center;">{{ $ledger->transaction_type }}</td>
                                <td>{{ $ledger->party_name }}</td>
                                <td style="text-align: center;">{{ $ledger->batch->batch_number ?? '-' }}</td>
                                <td style="text-align: right;">
                                    @if(in_array($ledger->transaction_type, ['IN', 'RETURN']))
                                        {{ number_format($ledger->quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if(in_array($ledger->transaction_type, ['OUT', 'ADJUSTMENT']))
                                        {{ number_format($ledger->quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="text-align: right; font-weight: bold;">{{ number_format($ledger->running_balance, 2) }}</td>
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('admin.items.expiry-ledger.delete', [$item, $ledger]) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="10" style="text-align: center; padding: 20px; color: #999;">
                                No expiry ledger entries found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($ledgers->hasPages())
            <div style="margin-top: 20px;">
                {{ $ledgers->links() }}
            </div>
        @endif

        <!-- Bottom Section -->
        <div class="ledger-footer">
            <div class="footer-section">
                <div class="footer-item">
                    <label>Salesman:</label>
                    <input type="text" readonly>
                </div>
                <div class="footer-item">
                    <label>Rate:</label>
                    <input type="text" value="0.00" readonly>
                </div>
                <div class="footer-item">
                    <label>Code:</label>
                    <input type="text" value="{{ $item->code ?? '-' }}" readonly>
                </div>
                <div class="footer-item">
                    <label>Address:</label>
                    <input type="text" readonly>
                </div>
            </div>

            <div class="footer-section">
                <div class="total-section">
                    <div style="margin-bottom: 5px;">Total:</div>
                    <div style="display: flex; justify-content: space-around; gap: 10px;">
                        <div>0</div>
                        <div>0</div>
                        <div>0</div>
                    </div>
                </div>
                <div class="footer-item">
                    <label>Balance:</label>
                    <input type="text" readonly>
                </div>
                <div class="footer-item">
                    <label>Sri.No.</label>
                    <input type="text" readonly>
                </div>
            </div>

            <div class="footer-section">
                <div class="total-section">
                    <div style="margin-bottom: 5px;">Excess Issued:</div>
                    <div style="display: flex; justify-content: space-around; gap: 10px;">
                        <div>0</div>
                        <div style="margin-left: 20px;">Effective:</div>
                        <div>0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Entry Form -->
        <div class="form-section">
            <h5 style="margin-top: 0;">Add New Expiry Ledger Entry</h5>
            <form method="POST" action="{{ route('admin.items.expiry-ledger.store', $item) }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Batch:</label>
                        <select name="batch_id" required style="width: 100%;">
                            <option value="">-- Select Batch --</option>
                            @foreach($item->batches as $batch)
                                <option value="{{ $batch->id }}">
                                    {{ $batch->batch_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Transaction Date:</label>
                        <input type="date" name="transaction_date" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Trans. No:</label>
                        <input type="text" name="trans_no" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label>Type:</label>
                        <select name="transaction_type" required>
                            <option value="">-- Select Type --</option>
                            <option value="IN">IN</option>
                            <option value="OUT">OUT</option>
                            <option value="RETURN">RETURN</option>
                            <option value="ADJUSTMENT">ADJUSTMENT</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Party Name:</label>
                        <input type="text" name="party_name" required placeholder="Customer/Supplier name">
                    </div>
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" required placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Free Quantity:</label>
                        <input type="number" name="free_quantity" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Running Balance:</label>
                        <input type="number" name="running_balance" step="0.01" required placeholder="0.00">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Expiry Date:</label>
                        <input type="date" name="expiry_date" required>
                    </div>
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

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.items.show', $item) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Item
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <style>
        @media print {
            .form-section, .action-buttons, .btn {
                display: none !important;
            }
        }
    </style>
@endsection
