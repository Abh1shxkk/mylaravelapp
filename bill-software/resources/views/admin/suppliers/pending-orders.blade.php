@extends('layouts.admin')
@section('title', 'Pending Orders - ' . $supplier->name)
@section('content')
    <style>
        .pending-order-header {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .pending-order-header-item {
            font-weight: bold;
        }

        .pending-order-header-item span {
            color: #0066cc;
            font-weight: bold;
            margin-left: 5px;
        }

        .pending-order-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .pending-order-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .pending-order-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .pending-order-table tr:first-child {
            background: #ffcccc;
        }

        .pending-order-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .sno-column,
        .qty-column,
        .free-qty-column,
        .other-order-column {
            text-align: center;
        }

        .remarks-section {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .remarks-section label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #0066cc;
        }

        .remarks-section textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            font-size: 12px;
            min-height: 60px;
        }

        .bill-history-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .bill-history-table th {
            background: #e9ecef;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        .bill-history-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .bill-history-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .bill-date-column,
        .qty-column,
        .free-column,
        .prate-column,
        .vat-column,
        .dis-column,
        .srate-column,
        .cost-column {
            text-align: right;
        }

        .footer-summary {
            background: #fff;
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-item {
            display: flex;
            gap: 10px;
            font-weight: bold;
        }

        .summary-item label {
            min-width: 120px;
        }

        .summary-item span {
            color: #0066cc;
            font-weight: bold;
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
        <div class="pending-order-header">
            <div class="pending-order-header-item">
                Name: <span>{{ $supplier->name }}</span>
            </div>
        </div>

        <!-- Pending Orders Table -->
        <div style="border: 2px solid #000; border-radius: 0; overflow: hidden; margin-bottom: 10px;">
            <table class="pending-order-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">O.No</th>
                        <th style="width: 10%;">Company</th>
                        <th style="width: 8%;">Bal qty</th>
                        <th style="width: 10%;">Item Code</th>
                        <th style="width: 25%;">Item Name</th>
                        <th style="width: 8%;">Pack</th>
                        <th style="width: 8%;">Order Qty</th>
                        <th style="width: 8%;">Free Qty</th>
                        <th style="width: 8%;">Other Order</th>
                        <th style="width: 10%;">Order Date</th>
                        <th style="width: 8%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->count() > 0)
                        @php $sno = 1; @endphp
                        @foreach($orders as $order)
                            <tr @if($sno === 1) style="background: #ffcccc;" @endif>
                                <td class="sno-column">{{ $sno }}</td>
                                <td style="text-align: center;">{{ $order->company_name ?? '-' }}</td>
                                <td class="qty-column">{{ $order->balance_qty ?? 0 }}</td>
                                <td style="text-align: center;">{{ $order->item_code ?? '---' }}</td>
                                <td>{{ $order->item_name ?? '-' }}</td>
                                <td style="text-align: center;">{{ $order->pack ?? '-' }}</td>
                                <td class="qty-column">{{ $order->order_qty ?? 0 }}</td>
                                <td class="free-qty-column">{{ $order->free_qty ?? 0 }}</td>
                                <td class="other-order-column">{{ $order->other_order ?? 0 }}</td>
                                <td style="text-align: center;">{{ $order->order_date->format('d-M-y') }}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#editOrderModal{{ $order->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.suppliers.pending-orders.destroy', [$supplier, $order]) }}" 
                                            style="display: inline;" onsubmit="return confirm('Delete this order?');">
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
                                No pending orders found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Remarks Section -->
        <div class="remarks-section">
            <label>Enter Remarks</label>
            <textarea placeholder="Enter remarks here..."></textarea>
        </div>

        <!-- Bill History Section -->
        <div style="margin-bottom: 10px;">
            <h5 style="margin-bottom: 10px; font-weight: bold;">Bill History</h5>
            <table class="bill-history-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">Date</th>
                        <th style="width: 10%;">Bill No.</th>
                        <th style="width: 15%;">Party</th>
                        <th style="width: 8%;">Qty.</th>
                        <th style="width: 8%;">Free</th>
                        <th style="width: 10%;">P.Rate</th>
                        <th style="width: 8%;">VAT%</th>
                        <th style="width: 8%;">Dis.%</th>
                        <th style="width: 10%;">S.Rate</th>
                        <th style="width: 10%;">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @if($billHistory->count() > 0)
                        @foreach($billHistory as $bill)
                            <tr>
                                <td class="bill-date-column">{{ $bill->date->format('d-M-y') }}</td>
                                <td style="text-align: center;">{{ $bill->bill_number }}</td>
                                <td>{{ $bill->party_name }}</td>
                                <td class="qty-column">{{ $bill->qty }}</td>
                                <td class="free-column">{{ $bill->free_qty }}</td>
                                <td class="prate-column">{{ number_format($bill->purchase_rate, 2) }}</td>
                                <td class="vat-column">{{ $bill->vat_percent }}</td>
                                <td class="dis-column">{{ $bill->discount_percent }}</td>
                                <td class="srate-column">{{ number_format($bill->selling_rate, 2) }}</td>
                                <td class="cost-column">{{ number_format($bill->cost, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="empty-message">
                                No bill history found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Footer Summary -->
        <div class="footer-summary">
            <div style="display: flex; gap: 30px;">
                <div class="summary-item">
                    <label>Item Cost:</label>
                    <span>{{ number_format($totalCost ?? 0, 2) }}</span>
                </div>
                <div class="summary-item">
                    <label>Total Value:</label>
                    <span>{{ number_format($totalValue ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Print (F7)
            </button>
            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                <i class="fas fa-plus"></i> Add New Order
            </button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-times"></i> Exit
            </a>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="pagination-section">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Add Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Pending Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.suppliers.pending-orders.store', $supplier) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Company Name:</label>
                                <input type="text" name="company_name" required placeholder="e.g., MICRO">
                            </div>
                            <div class="form-group">
                                <label>Item Code:</label>
                                <input type="text" name="item_code" placeholder="Optional">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Item Name:</label>
                                <input type="text" name="item_name" required placeholder="Item name">
                            </div>
                            <div class="form-group">
                                <label>Pack:</label>
                                <input type="text" name="pack" placeholder="e.g., 1*10">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Balance Qty:</label>
                                <input type="number" name="balance_qty" step="0.01" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label>Order Qty:</label>
                                <input type="number" name="order_qty" step="0.01" required placeholder="0">
                            </div>
                            <div class="form-group">
                                <label>Free Qty:</label>
                                <input type="number" name="free_qty" step="0.01" placeholder="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Other Order:</label>
                                <input type="number" name="other_order" step="0.01" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label>Order Date:</label>
                                <input type="date" name="order_date" value="{{ now()->toDateString() }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Order Modals -->
    @foreach($orders as $order)
        <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Order - {{ $order->item_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.suppliers.pending-orders.update', [$supplier, $order]) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Company Name:</label>
                                    <input type="text" name="company_name" value="{{ $order->company_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Code:</label>
                                    <input type="text" name="item_code" value="{{ $order->item_code }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Item Name:</label>
                                    <input type="text" name="item_name" value="{{ $order->item_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Pack:</label>
                                    <input type="text" name="pack" value="{{ $order->pack }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Balance Qty:</label>
                                    <input type="number" name="balance_qty" step="0.01" value="{{ $order->balance_qty }}">
                                </div>
                                <div class="form-group">
                                    <label>Order Qty:</label>
                                    <input type="number" name="order_qty" step="0.01" value="{{ $order->order_qty }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Free Qty:</label>
                                    <input type="number" name="free_qty" step="0.01" value="{{ $order->free_qty }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Other Order:</label>
                                    <input type="number" name="other_order" step="0.01" value="{{ $order->other_order }}">
                                </div>
                                <div class="form-group">
                                    <label>Order Date:</label>
                                    <input type="date" name="order_date" value="{{ $order->order_date->toDateString() }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Order</button>
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
