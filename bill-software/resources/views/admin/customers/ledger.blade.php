@extends('layouts.admin')
@section('title', 'Ledger - ' . $customer->name)
@section('content')
    <style>
        .ledger-container {
            background: #fff;
            padding: 0;
        }

        .ledger-title {
            background: #fff;
            border: 2px solid #000;
            padding: 10px 15px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: bold;
            color: #cc00cc;
        }

        .ledger-filter {
            background: #fff;
            border: 2px solid #000;
            border-top: none;
            padding: 12px 15px;
            margin-bottom: 0;
            font-size: 12px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-item label {
            font-weight: bold;
            min-width: 70px;
        }

        .filter-item input,
        .filter-item select {
            padding: 5px 8px;
            border: 1px solid #ccc;
            font-size: 11px;
            width: 100px;
        }

        .filter-item button {
            padding: 5px 10px;
            font-size: 11px;
            cursor: pointer;
            background: #ff0000;
            color: white;
            border: none;
            border-radius: 3px;
            font-weight: bold;
        }

        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 11px;
            margin-bottom: 0;
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

        .ledger-table tr:nth-child(2) {
            background: #4169e1;
            color: white;
        }

        .ledger-table tr:nth-child(2) td {
            text-align: center;
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

        .debit-column {
            text-align: right;
        }

        .credit-column {
            text-align: right;
        }

        .balance-column {
            text-align: right;
            font-weight: bold;
        }

        .transaction-type-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .sale-badge {
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

    <div class="ledger-container">
        <!-- Title -->
        <div class="ledger-title">
            {{ $customer->name }}
        </div>

        <!-- Filter Section -->
        <div class="ledger-filter">
            <div class="filter-item">
                <label>From :</label>
                <input type="date" id="fromDate" value="2025-04-01">
                <button style="background: #ff0000; color: white; padding: 4px 8px; border: none; cursor: pointer;">🔴</button>
            </div>
            <div class="filter-item">
                <label>To :</label>
                <input type="date" id="toDate" value="2025-10-28">
                <button style="background: #ff0000; color: white; padding: 4px 8px; border: none; cursor: pointer;">🔴</button>
            </div>
            <div class="filter-item">
                <label>With PDC :</label>
                <select>
                    <option>Y</option>
                    <option>N</option>
                </select>
                <button style="background: #0066cc; color: white; padding: 4px 8px; border: none; cursor: pointer;">🔍</button>
            </div>
        </div>

        <!-- Ledger Table -->
        <table class="ledger-table">
            <thead>
                <tr style="background: #e9ecef;">
                    <th style="width: 10%;">Vou. No.</th>
                    <th style="width: 10%;">Date</th>
                    <th style="width: 25%;">Account Name</th>
                    <th style="width: 15%;">Debit</th>
                    <th style="width: 15%;">Credit</th>
                    <th style="width: 25%;">Balance</th>
                </tr>
            </thead>
            <tbody>
                <!-- Opening Balance -->
                <tr class="opening-balance">
                    <td colspan="2"></td>
                    <td style="font-weight: bold;">Opening Bal. ( 01-Apr-25 )</td>
                    <td style="text-align: right; font-weight: bold;">83960.00</td>
                    <td></td>
                    <td style="text-align: right; font-weight: bold;">83960.00</td>
                </tr>

                <!-- Sample Rows -->
                <tr>
                    <td>S2 / 648</td>
                    <td>15-Apr-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">8398.00</td>
                    <td></td>
                    <td style="text-align: right;">92358.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 1218</td>
                    <td>30-Apr-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">2613.00</td>
                    <td></td>
                    <td style="text-align: right;">94971.00 Dr</td>
                </tr>
                <tr>
                    <td>RT / 2288</td>
                    <td>12-May-25</td>
                    <td>YES BANK LIMITED</td>
                    <td></td>
                    <td style="text-align: right;">29461.00</td>
                    <td style="text-align: right;">65510.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 1846</td>
                    <td>14-May-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">4264.00</td>
                    <td></td>
                    <td style="text-align: right;">69774.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 2493</td>
                    <td>30-May-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">1424.00</td>
                    <td></td>
                    <td style="text-align: right;">71198.00 Dr</td>
                </tr>
                <tr>
                    <td>RT / 2441</td>
                    <td>24-Jun-25</td>
                    <td>YES BANK LIMITED</td>
                    <td></td>
                    <td style="text-align: right;">5688.00</td>
                    <td style="text-align: right;">65510.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 3700</td>
                    <td>29-Jun-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">9525.00</td>
                    <td></td>
                    <td style="text-align: right;">75035.00 Dr</td>
                </tr>
                <tr>
                    <td>RT / 2551</td>
                    <td>24-Jul-25</td>
                    <td>YES BANK LIMITED</td>
                    <td></td>
                    <td style="text-align: right;">9525.00</td>
                    <td style="text-align: right;">65510.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 4986</td>
                    <td>31-Jul-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">10320.00</td>
                    <td></td>
                    <td style="text-align: right;">75830.00 Dr</td>
                </tr>
                <tr>
                    <td>S2 / 6244</td>
                    <td>30-Aug-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">13844.00</td>
                    <td></td>
                    <td style="text-align: right;">89674.00 Dr</td>
                </tr>
                <tr style="background: #dbeafe; font-weight: bold;">
                    <td>S2 / 6869</td>
                    <td>14-Sep-25</td>
                    <td>SALE</td>
                    <td style="text-align: right;">1570.00</td>
                    <td></td>
                    <td style="text-align: right;">91244.00 Dr</td>
                </tr>

                <!-- Empty Rows -->
                <tr><td colspan="6"></td></tr>
                <tr><td colspan="6"></td></tr>

                <!-- Closing Balance -->
                <tr class="closing-balance">
                    <td colspan="2" style="text-align: right; padding-right: 10px;"><strong>" " - PDC</strong></td>
                    <td style="text-align: center;"><strong>Closing Bal. ( 28-Oct-25 )</strong></td>
                    <td style="text-align: right;"><strong>91244.00</strong></td>
                    <td></td>
                    <td style="text-align: right;"><strong>91244.00</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Summary Section -->
        <div style="background: #fff; border: 2px solid #000; border-top: none; padding: 12px 15px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; font-size: 11px;">
            <div>
                <label style="font-weight: bold;">Narration :</label>
                <span style="color: #0066cc;">INVOICE NO. 6869</span>
            </div>
            <div style="text-align: center;">
                <label style="font-weight: bold;">Total :</label>
                <span style="color: #0066cc;">51958.00</span>
                <span style="margin-left: 20px; font-weight: bold;">44674.00</span>
            </div>
            <div style="text-align: right;">
                <label style="font-weight: bold;">Current Bal :</label>
                <span style="color: #cc00cc; font-weight: bold;">91244.00 Dr</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-outline-success btn-sm">
                <i class="fas fa-print"></i> Print (F7)
            </button>
            <button class="btn btn-outline-info btn-sm">
                <i class="fas fa-file"></i> Print Summary
            </button>
            <button class="btn btn-outline-info btn-sm">
                <i class="fas fa-calculator"></i> Print with Interest (F8)
            </button>
            <button class="btn btn-outline-primary btn-sm" onclick="openBillHistoryModal()">
                <i class="fas fa-history"></i> Bill History (F5)
            </button>
            <button class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-filter"></i> Date Range (F3)
            </button>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <!-- Print Section -->
        <div style="background: #fff; border: 2px solid #000; padding: 15px; margin-top: 20px; min-height: 300px;">
            <div style="text-align: center; color: #999; padding: 50px;">
                Print content will appear here
            </div>
        </div>
    </div>

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
                                    <td style="border-right: 1px solid #ddd; padding: 5px; width: 8%; text-align: center;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 5px; width: 12%;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 5px; width: 15%;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 5px; width: 12%; text-align: right;"></td>
                                    <td style="border-right: 1px solid #ddd; padding: 5px; width: 12%; text-align: right;"></td>
                                    <td style="padding: 5px; width: 41%;"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Info -->
                <div style="background: #fff; border: 2px solid #000; padding: 10px; text-align: right; font-weight: bold;">
                    <span style="color: #0066cc;">Total Amount : </span>
                    <span id="billHistoryTotalAmount" style="color: #0066cc;">0.00</span>
                </div>
            </div>
        </div>
    </div>

    <div id="billHistoryModalBackdrop" class="bill-history-modal-backdrop"></div>

    <style>
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
            padding: 20px;
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

        .btn-close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }

        .btn-close-modal:hover {
            color: #000;
        }
    </style>

    <script>
        // Bill History Modal Functions
        function openBillHistoryModal() {
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

        // Close modal when clicking backdrop
        document.addEventListener('DOMContentLoaded', function() {
            const backdrop = document.getElementById('billHistoryModalBackdrop');
            if (backdrop) {
                backdrop.addEventListener('click', closeBillHistoryModal);
            }
        });
    </script>

    @endsection
