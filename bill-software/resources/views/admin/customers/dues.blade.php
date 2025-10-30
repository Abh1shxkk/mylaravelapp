@extends('layouts.admin')
@section('title', 'Due List - ' . $customer->name)
@section('content')
    <style>
        .due-header {
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
        }

    .due-table {
        font-size: 12px;
    }

    .due-table th {
        background: #f3f4f6;
        font-weight: 600;
        font-size: 11px;
    }

    .due-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .due-table tbody tr:hover {
        background: #f9fafb;
    }

    .due-table tbody tr.selected {
        background: #dbeafe !important;
        border-left: 4px solid #0066cc !important;
        box-shadow: inset 0 0 10px rgba(0, 102, 204, 0.2);
        font-weight: 500;
    }

    .sno-column,
    .days-column,
    .amount-column {
        text-align: center;
        font-weight: 500;
    }

    .footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .footer-item {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .footer-item label {
        font-weight: 500;
        min-width: 100px;
        font-size: 12px;
    }

    .footer-item span {
        font-weight: 600;
    }

    .info-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-top: 12px;
        font-size: 11px;
    }

    .info-item {
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    .info-item label {
        font-weight: 500;
        min-width: 80px;
    }

    .action-buttons {
        padding: 10px;
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 15px;
    }

    .action-buttons button,
    .action-buttons a {
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 500;
        border-radius: 4px;
        transition: all 0.15s ease;
        cursor: pointer;
    }

    .action-buttons button:hover,
    .action-buttons a:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .empty-message {
        text-align: center;
        padding: 40px;
        color: #999;
        font-style: italic;
        font-size: 13px;
    }

    .hold-badge {
        background: #ffe6e6;
        color: #cc0000;
        padding: 6px 10px;
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        font-size: 11px;
    }

    .expiry-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 8px 14px;
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
        display: inline-block;
    }

    .expiry-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }
</style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-receipt me-2"></i> Due List</h4>
            <div class="text-muted small">{{ $customer->name }} ({{ $customer->code ?? '-' }})</div>
        </div>
    </div>

    <div class="card shadow-sm">
        <!-- Due List Table -->
        <div class="table-responsive">
            <table class="due-table table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sr.No</th>
                        <th style="width: 10%;">Trans No.</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 8%;">Days</th>
                        <th style="width: 10%;">Due Date</th>
                        <th style="width: 8%;">Days</th>
                        <th style="width: 12%;">Trn.Amt.</th>
                        <th style="width: 12%;">Debit</th>
                        <th style="width: 12%;">Credit</th>
                        <th style="width: 8%;">Hold</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dues as $due)
                        <tr class="due-row" onclick="selectDueRow(this, {{ $due->id }}, '{{ $due->trans_no }}', '{{ $due->invoice_date->format('d-M-y') }}', {{ $due->trans_amount }}, {{ $due->debit }}, {{ $due->credit }})" style="cursor: pointer; transition: background-color 0.2s ease;">
                            <td class="sno-column" style="font-weight: bold;">{{ $loop->iteration }}</td>
                            <td style="text-align: center;">{{ $due->trans_no }}</td>
                            <td style="text-align: center;">{{ $due->invoice_date->format('d-M-y') }}</td>
                            <td class="days-column">{{ (int)\Carbon\Carbon::now()->diffInDays($due->invoice_date) }}</td>
                            <td style="text-align: center;">{{ $due->due_date->format('d-M-y') }}</td>
                            <td class="days-column">{{ (int)\Carbon\Carbon::now()->diffInDays($due->due_date) }}</td>
                            <td class="amount-column">{{ number_format($due->trans_amount, 2) }}</td>
                            <td class="amount-column">{{ number_format($due->debit, 2) }}</td>
                            <td class="amount-column">{{ number_format($due->credit, 2) }}</td>
                            <td style="text-align: center;">
                                @if($due->hold)
                                    <span class="hold-badge">HOLD</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="empty-message">No due entries found. Click "Add New (F9)" to add one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Summary -->
        <div class="card-footer">
            @php
                $totalAmount = 91244.00;
                $totalDebit = 91244.00;
                $totalCredit = 0.00;
                $pdc = 0.00;
            @endphp
            <div class="footer-row">
                <div class="footer-item">
                    <label>( Ledger )</label>
                    <span>{{ number_format($totalAmount, 2) }} Dr</span>
                </div>
                <div class="footer-item">
                    <label>( D. L. )</label>
                    <span>{{ number_format($totalDebit, 2) }} Dr</span>
                </div>
                <div class="footer-item">
                    <label>( Diff. )</label>
                    <span>{{ number_format(0, 2) }}</span>
                </div>
                <div>
                    <a href="{{ route('admin.customers.dues.expiry-list', $customer) }}" class="expiry-badge" style="text-decoration: none; display: inline-block;">
                        Expiry Due List
                    </a>
                </div>
            </div>

            <!-- Summary Row -->
            <div class="footer-row">
                <div class="footer-item">
                    <label>PDC :</label>
                    <span>{{ number_format($pdc, 2) }}</span>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-row">
                <div class="info-item">
                    <label>GR.No. :</label>
                    <span>-</span>
                </div>
                <div class="info-item">
                    <label>GR.Date:</label>
                    <span>-</span>
                </div>
                <div class="info-item">
                    <label>Trans. :</label>
                    <span>-</span>
                </div>
                <div class="info-item">
                    <label>Case :</label>
                    <span>-</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <label>Sales Man :</label>
                    <span>{{ $customer->sales_man ?? 'DIRECT' }}</span>
                </div>
                <div class="info-item">
                    <label>Area :</label>
                    <span>{{ $customer->area ?? 'DIRECT' }}</span>
                </div>
                <div class="info-item">
                    <label>Route :</label>
                    <span>{{ $customer->route ?? 'DIRECT' }}</span>
                </div>
                <div class="info-item">
                    <label>Day :</label>
                    <span>-</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item" style="grid-column: 1 / 2;">
                    <label>Tag :</label>
                    <span>-</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-outline-info btn-sm">
                <i class="fas fa-list"></i> With Item Detail
            </button>
            <button class="btn btn-outline-info btn-sm" onclick="openAmtTransferModal()">
                <i class="fas fa-exchange"></i> Amt. Transfer
            </button>
            <button class="btn btn-outline-info btn-sm" onclick="openPDCModal()">
                <i class="fas fa-list"></i> List of PDC(F6)
            </button>
            <button class="btn btn-outline-info btn-sm" onclick="openBillHistoryModal()">
                <i class="fas fa-history"></i> Bill History (F5)
            </button>
            <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-print"></i> Print (F7)
            </button>
            <a href="{{ route('admin.customers.ledger', $customer) }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-book"></i> Ledger (F10)
            </a>
            <button class="btn btn-outline-success btn-sm" onclick="openAddDueModal()">
                <i class="fas fa-plus"></i> Add New (F9)
            </button>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-times"></i> Exit
            </a>
        </div>

        <!-- To Excel Button -->
        <div style="text-align: center; margin-bottom: 20px;">
            <button class="btn btn-outline-success btn-sm">
                <i class="fas fa-file-excel"></i> To Excel
            </button>
        </div>
    </div>

    <!-- List of PDC Sliding Modal -->
    <div id="pdcListModal" class="pdc-modal">
        <div class="pdc-modal-content">
            <div class="pdc-modal-header">
                <h5 class="pdc-modal-title">
                    <i class="fas fa-list me-2"></i>TOTAL POST DATED CHEQUE(S) AMOUNT Rs 0.00
                </h5>
                <button type="button" class="btn-close-modal" onclick="closePDCModal()" title="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="pdc-modal-body">
                <!-- Customer Info -->
                <div style="background: #fff; border: 1px solid #000; padding: 10px; margin-bottom: 10px;">
                    <div style="display: flex; gap: 30px; font-weight: bold; font-size: 12px;">
                        <div>CODE : </div>
                        <div>NAME : {{ $customer->name }}</div>
                    </div>
                </div>

                <!-- PDC Table -->
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 11px; margin-bottom: 10px;">
                    <thead>
                        <tr style="background: #0066cc; color: white;">
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">SR.NO</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">TRNS.NO.</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">CHQ.NO</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">CHQ.DATE</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">AMOUNT</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">BANK</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center;">DAY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pdcRows = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                        @endphp
                        @foreach($pdcRows as $row)
                            <tr @if($row === 1) style="background: #0066cc; color: white;" @endif>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ $row }}</td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                <td style="border: 1px solid #000; padding: 8px;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total Row -->
                <div style="background: #fff; border: 1px solid #000; padding: 10px; text-align: right; font-weight: bold; font-size: 12px; margin-bottom: 10px;">
                    <span style="color: #00aa00;">Total :</span>
                    <span style="color: #ff0000; margin-left: 20px;">0.00</span>
                </div>

                <!-- Summary Sections -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <!-- Amount Outstanding -->
                    <div style="border: 2px solid #000; background: #ccffff; display: flex; flex-direction: column;">
                        <div style="background: #ccffff; padding: 8px; font-weight: bold; font-size: 12px; border-bottom: 1px solid #000; flex-shrink: 0;">
                            1) Amt. Outstanding
                            <span style="float: right;">Total :</span>
                        </div>
                        <div style="flex: 1; overflow-y: auto; border: 1px solid #000;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                                <tbody>
                                    @php $rows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; @endphp
                                    @foreach($rows as $row)
                                        <tr style="border-bottom: 1px solid #ddd; height: 25px;">
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="padding: 4px;"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Amount Adjusted -->
                    <div style="border: 2px solid #000; background: #ccffff; display: flex; flex-direction: column;">
                        <div style="background: #ccffff; padding: 8px; font-weight: bold; font-size: 12px; border-bottom: 1px solid #000; flex-shrink: 0;">
                            2) Amt. Adjusted
                            <span style="float: right;">Total :</span>
                        </div>
                        <div style="flex: 1; overflow-y: auto; border: 1px solid #000;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                                <tbody>
                                    @php $rows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; @endphp
                                    @foreach($rows as $row)
                                        <tr style="border-bottom: 1px solid #ddd; height: 25px;">
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                            <td style="padding: 4px;"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pdcModalBackdrop" class="pdc-modal-backdrop"></div>

    <!-- Bill History Sliding Modal -->
    <div id="billHistoryModal" class="bill-history-modal">
        <div class="bill-history-modal-content">
            <div class="bill-history-modal-header">
                <h5 class="bill-history-modal-title">
                    <i class="fas fa-history me-2"></i>Bill History
                </h5>
                <button type="button" class="btn-close-modal" onclick="closeBillHistoryModal()" title="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="bill-history-modal-body">
                <!-- Bill Details Header -->
                <div style="background: #fff; border: 2px solid #000; padding: 15px; margin-bottom: 10px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div>
                            <span style="font-weight: bold;">Trn. No. :</span>
                            <span style="color: #0066cc; font-weight: bold; margin-left: 10px;" id="billHistoryTransNo">-</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-weight: bold;">Trn. Date :</span>
                            <span style="color: #0066cc; font-weight: bold; margin-left: 10px;" id="billHistoryDate">-</span>
                        </div>
                    </div>
                    <div style="text-align: right; font-weight: bold;">
                        <span>Trn. Amount :</span>
                        <span style="color: #0066cc; margin-left: 10px;" id="billHistoryAmount">0.00</span>
                    </div>
                </div>

                <!-- Bill Items Table -->
                <div style="background: #fff; border: 2px solid #000; padding: 0; margin-bottom: 10px; min-height: 200px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                        <tbody>
                            @php $billRows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; @endphp
                            @foreach($billRows as $row)
                                <tr style="border-bottom: 1px solid #ddd; height: 25px; @if($row === 1) background: #ffcccc; @endif">
                                    <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 4px;"></td>
                                    <td style="padding: 4px;"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <div style="background: #fff; border: 2px solid #000; padding: 15px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div>
                            <span style="font-weight: bold;">Amount Outstanding :</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="color: #0066cc; font-weight: bold;">6166.00</span>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                        <div>
                            <span style="font-weight: bold;">O/S as Per Due List :</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="color: #0066cc; font-weight: bold;">6166.00</span>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <span style="font-weight: bold;">Difference :</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="color: #0066cc; font-weight: bold;">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="billHistoryModalBackdrop" class="bill-history-modal-backdrop"></div>

    <!-- Amount Transfer Sliding Modal -->
    <div id="amtTransferModal" class="amt-transfer-modal">
        <div class="amt-transfer-modal-content">
            <div class="amt-transfer-modal-header">
                <h5 class="amt-transfer-modal-title">
                    <i class="fas fa-exchange me-2"></i>Amount Transfer
                </h5>
                <button type="button" class="btn-close-modal" onclick="closeAmtTransferModal()" title="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="amt-transfer-modal-body">
                <!-- Amount Transfer Table -->
                <table style="width: 100%; border-collapse: collapse; font-size: 11px; border: 1px solid #000;">
                    <thead>
                        <tr style="background: #667eea; color: white;">
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 10%;">SR.NO.</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 20%;">TRANS NO.</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 15%;">DATE</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 18%;">BILL AMT.</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 18%;">ADJUSTED</th>
                            <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 19%;">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $amtRows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]; @endphp
                        @foreach($amtRows as $row)
                            <tr style="border-bottom: 1px solid #000;">
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;"></td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;"></td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: center;"></td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;"></td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;"></td>
                                <td style="border: 1px solid #000; padding: 8px; text-align: right;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Footer Info -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; padding: 15px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px;">
                    <div>
                        <span style="font-weight: bold; color: #cc0000;">EXIT : &lt;ESC&gt;</span>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-weight: bold; color: #0066cc;">BALANCE (Rs) : -6166.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="amtTransferModalBackdrop" class="amt-transfer-modal-backdrop"></div>

    <!-- Add Due Sliding Modal -->
    <div id="addDueModal" class="add-due-modal">
        <div class="add-due-modal-content">
            <div class="add-due-modal-header">
                <h5 class="add-due-modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Due Entry
                </h5>
                <button type="button" class="btn-close-modal" onclick="closeAddDueModal()" title="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="add-due-modal-body">
                <form method="POST" action="{{ route('admin.customers.dues.store', $customer) }}" id="addDueForm">
                    @csrf
                    <!-- First Row: Series and Date -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="font-weight: bold; margin-bottom: 8px; display: block; font-size: 12px;">Series :</label>
                            <input type="text" name="series" placeholder="SB" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                        </div>
                        <div>
                            <label style="font-weight: bold; margin-bottom: 8px; display: block; font-size: 12px;">Date :</label>
                            <input type="date" name="invoice_date" value="{{ now()->toDateString() }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                        </div>
                    </div>

                    <!-- Second Row: Bill No and O/S Amount -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="font-weight: bold; margin-bottom: 8px; display: block; font-size: 12px;">Bill No. :</label>
                            <input type="text" name="trans_no" placeholder="455" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                        </div>
                        <div>
                            <label style="font-weight: bold; margin-bottom: 8px; display: block; font-size: 12px;">O/S Amount :</label>
                            <input type="number" name="trans_amount" step="0.01" placeholder="0.00" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div style="margin-bottom: 20px; padding: 15px; background: #f0f8ff; border-radius: 4px;">
                        <label style="display: flex; align-items: center; gap: 10px; font-size: 12px; cursor: pointer;">
                            <input type="checkbox" name="update_ledger" value="1">
                            <span style="font-weight: bold;">Update Ledger Opening Balance</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 30px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="closeAddDueModal()" style="padding: 10px; font-weight: bold;">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm" style="padding: 10px; font-weight: bold;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="addDueModalBackdrop" class="add-due-modal-backdrop"></div>

    <style>
        /* PDC Modal Styles */
        .pdc-modal {
            position: fixed;
            top: 0;
            right: -900px;
            width: 900px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .pdc-modal.show {
            right: 0;
        }

        .pdc-modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .pdc-modal-header {
            background: #f8f9fa;
            border-bottom: 2px solid #000;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .pdc-modal-title {
            margin: 0;
            color: #0066cc;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #000;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-close-modal:hover {
            color: #0066cc;
        }

        .pdc-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .pdc-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .pdc-modal-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Bill History Modal Styles */
        .bill-history-modal {
            position: fixed;
            top: 0;
            right: -900px;
            width: 900px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .bill-history-modal.show {
            right: 0;
        }

        .bill-history-modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .bill-history-modal-header {
            background: #f8f9fa;
            border-bottom: 2px solid #000;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .bill-history-modal-title {
            margin: 0;
            color: #0066cc;
            font-weight: bold;
            font-size: 14px;
        }

        .bill-history-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .bill-history-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .bill-history-modal-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Add Due Modal Styles */
        .add-due-modal {
            position: fixed;
            top: 0;
            right: -900px;
            width: 900px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .add-due-modal.show {
            right: 0;
        }

        .add-due-modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .add-due-modal-header {
            background: #f8f9fa;
            border-bottom: 2px solid #000;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .add-due-modal-title {
            margin: 0;
            color: #0066cc;
            font-weight: bold;
            font-size: 14px;
        }

        .add-due-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .add-due-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .add-due-modal-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Amount Transfer Modal Styles */
        .amt-transfer-modal {
            position: fixed;
            top: 0;
            right: -900px;
            width: 900px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .amt-transfer-modal.show {
            right: 0;
        }

        .amt-transfer-modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .amt-transfer-modal-header {
            background: #f8f9fa;
            border-bottom: 2px solid #000;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .amt-transfer-modal-title {
            margin: 0;
            color: #0066cc;
            font-weight: bold;
            font-size: 14px;
        }

        .amt-transfer-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .amt-transfer-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .amt-transfer-modal-backdrop.show {
            display: block;
            opacity: 1;
        }

        @media print {
            .action-buttons, .modal, .btn-group, .pdc-modal, .pdc-modal-backdrop {
                display: none !important;
            }
        }
    </style>

    <script>
        // Global variable to store selected due
        let selectedDue = null;

        // Select due row
        function selectDueRow(row, dueId, transNo, date, amount, debit, credit) {
            // Remove previous selection
            const previousSelected = document.querySelector('.due-row.selected');
            if (previousSelected) {
                previousSelected.classList.remove('selected');
                previousSelected.style.background = '';
            }

            // Add selection to current row
            row.classList.add('selected');
            row.style.background = '#e3f2fd';

            // Store selected due data
            selectedDue = {
                id: dueId,
                transNo: transNo,
                date: date,
                amount: amount,
                debit: debit,
                credit: credit
            };

            console.log('Selected Due:', selectedDue);
        }

        function openPDCModal() {
            const modal = document.getElementById('pdcListModal');
            const backdrop = document.getElementById('pdcModalBackdrop');
            
            backdrop.style.display = 'block';
            modal.style.display = 'flex';
            
            setTimeout(() => {
                backdrop.classList.add('show');
                modal.classList.add('show');
            }, 10);
        }

        function closePDCModal() {
            const modal = document.getElementById('pdcListModal');
            const backdrop = document.getElementById('pdcModalBackdrop');
            
            modal.classList.remove('show');
            backdrop.classList.remove('show');
            
            setTimeout(() => {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
            }, 300);
        }

        // Close modal when clicking backdrop
        document.addEventListener('DOMContentLoaded', function() {
            const backdrop = document.getElementById('pdcModalBackdrop');
            if (backdrop) {
                backdrop.addEventListener('click', closePDCModal);
            }

            const billBackdrop = document.getElementById('billHistoryModalBackdrop');
            if (billBackdrop) {
                billBackdrop.addEventListener('click', closeBillHistoryModal);
            }
        });

        // Bill History Modal Functions
        function openBillHistoryModal() {
            // Check if a due is selected
            if (!selectedDue) {
                alert('Please select a transaction from the table first!');
                return;
            }

            // Populate bill history modal with selected due data
            document.getElementById('billHistoryTransNo').textContent = selectedDue.transNo;
            document.getElementById('billHistoryDate').textContent = selectedDue.date;
            document.getElementById('billHistoryAmount').textContent = parseFloat(selectedDue.amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            const modal = document.getElementById('billHistoryModal');
            const backdrop = document.getElementById('billHistoryModalBackdrop');
            
            backdrop.style.display = 'block';
            modal.style.display = 'flex';
            
            setTimeout(() => {
                backdrop.classList.add('show');
                modal.classList.add('show');
            }, 10);
        }

        function closeBillHistoryModal() {
            const modal = document.getElementById('billHistoryModal');
            const backdrop = document.getElementById('billHistoryModalBackdrop');
            
            modal.classList.remove('show');
            backdrop.classList.remove('show');
            
            setTimeout(() => {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
            }, 300);
        }

        // Add Due Modal Functions
        function openAddDueModal() {
            const modal = document.getElementById('addDueModal');
            const backdrop = document.getElementById('addDueModalBackdrop');
            
            backdrop.style.display = 'block';
            modal.style.display = 'flex';
            
            setTimeout(() => {
                backdrop.classList.add('show');
                modal.classList.add('show');
            }, 10);
        }

        function closeAddDueModal() {
            const modal = document.getElementById('addDueModal');
            const backdrop = document.getElementById('addDueModalBackdrop');
            
            modal.classList.remove('show');
            backdrop.classList.remove('show');
            
            setTimeout(() => {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
            }, 300);
        }

        // Amount Transfer Modal Functions
        function openAmtTransferModal() {
            const modal = document.getElementById('amtTransferModal');
            const backdrop = document.getElementById('amtTransferModalBackdrop');
            
            backdrop.style.display = 'block';
            modal.style.display = 'flex';
            
            setTimeout(() => {
                backdrop.classList.add('show');
                modal.classList.add('show');
            }, 10);
        }

        function closeAmtTransferModal() {
            const modal = document.getElementById('amtTransferModal');
            const backdrop = document.getElementById('amtTransferModalBackdrop');
            
            modal.classList.remove('show');
            backdrop.classList.remove('show');
            
            setTimeout(() => {
                backdrop.style.display = 'none';
                modal.style.display = 'none';
            }, 300);
        }

        // Close modals when clicking backdrop
        document.addEventListener('DOMContentLoaded', function() {
            const addDueBackdrop = document.getElementById('addDueModalBackdrop');
            if (addDueBackdrop) {
                addDueBackdrop.addEventListener('click', closeAddDueModal);
            }

            const amtTransferBackdrop = document.getElementById('amtTransferModalBackdrop');
            if (amtTransferBackdrop) {
                amtTransferBackdrop.addEventListener('click', closeAmtTransferModal);
            }
        });
    </script>
@endsection
