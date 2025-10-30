@extends('layouts.admin')
@section('title', 'Pending Challans - ' . $customer->name)
@section('content')
    <style>
        .challan-container {
            background: #fff;
            border: 2px solid #000;
            padding: 0;
            margin-bottom: 20px;
        }

        .challan-header {
            background: #fff;
            border-bottom: 2px solid #000;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .challan-header-left {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .challan-header-item {
            font-weight: bold;
        }

        .challan-header-item span {
            color: #0066cc;
            font-weight: bold;
            margin-left: 8px;
        }

        .challan-header-right {
            color: #0066cc;
            font-weight: bold;
            font-style: italic;
            font-size: 12px;
        }

        .challan-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            font-size: 12px;
            margin-bottom: 0;
        }

        .challan-table th {
            background: #4169e1;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: white;
        }

        .challan-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
            height: 30px;
        }

        .challan-table tr:first-child td {
            background: #ffffff;
            color: #000;
        }

        .challan-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .challan-footer {
            background: #fff;
            border-top: 2px solid #000;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }

        .footer-buttons {
            display: flex;
            gap: 10px;
        }

        .footer-buttons button {
            padding: 6px 14px;
            font-weight: bold;
            cursor: pointer;
            border: 1px solid #000;
            background: #fff;
            border-radius: 3px;
        }

        .footer-buttons button:hover {
            background: #f0f0f0;
        }

        .total-section {
            text-align: right;
            font-weight: bold;
        }

        .total-section label {
            margin-right: 10px;
        }

        .total-section span {
            color: #cc0000;
            font-size: 14px;
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

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }

        .pending-badge {
            background: #ffcccc;
            color: #cc0000;
        }

        .partial-badge {
            background: #ffcc99;
            color: #cc6600;
        }

        .delivered-badge {
            background: #ccffcc;
            color: #00cc00;
        }

        .cancelled-badge {
            background: #cccccc;
            color: #666666;
        }

        .progress-bar-container {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border: 1px solid #ccc;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #4169e1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }

        .hold-badge {
            background: #ffcccc;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <div class="challan-container">
        <!-- Header -->
        <div class="challan-header">
            <div class="challan-header-left">
                <div class="challan-header-item">Party Name : <span>{{ $customer->name }}</span></div>
            </div>
            <div class="challan-header-right">
                Press " " To Hold
            </div>
        </div>

        <!-- Challans Table -->
        <table class="challan-table">
            <thead>
                <tr>
                    <th style="width: 33%;">DATE</th>
                    <th style="width: 33%;">TRN.No</th>
                    <th style="width: 17%;">AMOUNT</th>
                    <th style="width: 17%;">HOLD</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Rows -->
                @php $challanRows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; @endphp
                @foreach($challanRows as $row)
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"></td>
                        <td style="text-align: center;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="challan-footer">
            <div class="footer-buttons">
                <button onclick="window.print()">Print</button>
                <button onclick="window.history.back()">Close</button>
            </div>
            <div class="total-section">
                <label>Total :</label>
                <span>{{ number_format($challans->sum('amount'), 2) }}</span>
            </div>
        </div>
    </div>

    @endsection
