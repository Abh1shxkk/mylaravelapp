@extends('layouts.admin')
@section('title', 'Pending Orders - ' . $item->name)
@section('content')
    <style>
        .pending-header {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .pending-table {
            font-size: 12px;
            border-collapse: collapse;
        }
        .pending-table th {
            background: #e9ecef;
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        .pending-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .pending-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
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
            margin-bottom: 20px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        .pending-row {
            background: #fff3cd;
        }
        .received-row {
            background: #d4edda;
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="pending-header">
            <h4 style="margin: 0; color: #0d6efd;">
                <strong>PENDING ORDERS</strong>
            </h4>
            <div style="margin-top: 10px; font-size: 13px;">
                <strong>Item:</strong> {{ $item->name }} | 
                <strong>Packing:</strong> {{ $item->packing ?? '1*1' }} | 
                <strong>Qty:</strong> {{ $item->getTotalQuantity() }}
            </div>
        </div>

        <!-- Pending Orders Table -->
        <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
            <table class="pending-table" style="width: 100%; margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="width: 14%;">Supplier Name</th>
                        <th style="width: 8%;">Date</th>
                        <th style="width: 8%;">Rate</th>
                        <th style="width: 6%;">Tax%</th>
                        <th style="width: 6%;">Dis%</th>
                        <th style="width: 6%;">Ex.</th>
                        <th style="width: 8%;">Cost</th>
                        <th style="width: 6%;">SCM%</th>
                        <th style="width: 6%;">Qty</th>
                        <th style="width: 6%;">Days</th>
                        <th style="width: 12%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pendingOrders->count() > 0)
                        @foreach($pendingOrders as $order)
                            <tr class="pending-row">
                                <!-- Supplier Name -->
                                <td>
                                    <strong>{{ $order->supplier->code ?? 'N/A' }}</strong><br>
                                    {{ $order->supplier->name }}
                                </td>
                                <!-- Date -->
                                <td style="text-align: center;">{{ $order->order_date->format('d-M-y') }}</td>
                                <!-- Rate -->
                                <td style="text-align: right;">{{ number_format($order->rate, 2) }}</td>
                                <!-- Tax% -->
                                <td style="text-align: center;">{{ $order->tax_percent > 0 ? number_format($order->tax_percent, 2) : '-' }}</td>
                                <!-- Dis% (Discount%) -->
                                <td style="text-align: center;">{{ $order->discount_percent > 0 ? number_format($order->discount_percent, 2) : '-' }}</td>
                                <!-- Ex. (Extra/Excise) -->
                                <td style="text-align: center;">-</td>
                                <!-- Cost -->
                                <td style="text-align: right;">{{ number_format($order->cost, 2) }}</td>
                                <!-- SCM% -->
                                <td style="text-align: center;">{{ $order->scm_percent > 0 ? number_format($order->scm_percent, 2) : '-' }}</td>
                                <!-- Qty -->
                                <td style="text-align: center; font-weight: bold;">{{ $order->quantity }}</td>
                                <!-- Days -->
                                <td style="text-align: center;">
                                    @php
                                        $days = now()->diffInDays($order->order_date);
                                    @endphp
                                    {{ $days }}
                                </td>
                                <!-- Actions -->
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('admin.items.pending-orders.receive', [$item, $order]) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Mark as Received">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.items.pending-orders.delete', [$item, $order]) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="10" style="text-align: center; padding: 20px; color: #999;">
                                No pending orders found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pendingOrders->hasPages())
            <div style="margin-top: 20px;">
                {{ $pendingOrders->links() }}
            </div>
        @endif

       

        <!-- Add New Pending Order Form -->
        <div class="form-section" style="margin-top: 20px;">
            <h5 style="margin-top: 0;">SUPPLIER: PENDING ORDER</h5>
            <form method="POST" action="{{ route('admin.items.pending-orders.store', $item) }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Supplier Name:</label>
                        <select name="supplier_id" required style="width: 100%;">
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">
                                    {{ $supplier->code ?? 'N/A' }} - {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Order Date:</label>
                        <input type="date" name="order_date" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="form-group">
                        <label>Rate:</label>
                        <input type="number" name="rate" step="0.01" min="0" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Tax %:</label>
                        <input type="number" name="tax_percent" step="0.01" min="0" max="100" placeholder="0.00">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Discount %:</label>
                        <input type="number" name="discount_percent" step="0.01" min="0" max="100" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Cost:</label>
                        <input type="number" name="cost" step="0.01" min="0" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>SCM %:</label>
                        <input type="number" name="scm_percent" step="0.01" min="0" max="100" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" min="1" required placeholder="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Free Quantity:</label>
                        <input type="number" name="free_quantity" min="0" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Urgent [Y/N]:</label>
                        <select name="urgent_flag">
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Scheme:</label>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <input type="number" name="scheme_plus" min="0" placeholder="0" style="flex: 1; padding: 6px 8px; border: 1px solid #dee2e6; border-radius: 3px;">
                            <span style="font-weight: bold; font-size: 16px; color: #dc3545;">+</span>
                            <input type="number" name="scheme_minus" min="0" placeholder="0" style="flex: 1; padding: 6px 8px; border: 1px solid #dee2e6; border-radius: 3px;">
                        </div>
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
                        <i class="fas fa-plus"></i> Add Pending Order
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
