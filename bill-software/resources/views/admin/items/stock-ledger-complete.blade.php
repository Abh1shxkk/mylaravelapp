@extends('layouts.admin')
@section('title', 'Stock Ledger - ' . $item->name)
@section('content')
    <style>
        .ledger-header {
            background: #f8f9fa;
            padding: 12px;
            border: 1px solid #dee2e6;
            margin-bottom: 10px;
            font-size: 13px;
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
            min-width: 100px;
            margin: 0;
        }
        .ledger-header-item input,
        .ledger-header-item select {
            padding: 4px 8px;
            font-size: 12px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
        }
        .ledger-table {
            font-size: 12px;
            border-collapse: collapse;
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
        .ledger-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .ledger-footer {
            background: #f8f9fa;
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
    </style>

    <div class="container-fluid">
        <!-- EasySol Style Header -->
        <div class="ledger-header">
            <div class="ledger-header-row">
                <div class="ledger-header-item">
                    <label>ITEM:</label>
                    <strong style="color: #0d6efd;">{{ $item->name }}</strong>
                </div>
                <div class="ledger-header-item">
                    <label>PACK:</label>
                    <strong>{{ $item->packing ?? '1*1 UNIT' }}</strong>
                </div>
                <!-- Party Code Dropdown -->
                <div class="ledger-header-item">
                    <label>Party Code:</label>
                    <select id="party_code_select" name="party_code" style="width: 280px; padding: 6px 8px; border: 1px solid #dee2e6; border-radius: 3px; font-size: 14px;">
                        <option value="">-- Select Party --</option>
                        <optgroup label="Customers">
                            @foreach($customers as $customer)
                                <option value="C{{ $customer->id }}" 
                                        data-code="{{ $customer->code ?? 'N/A' }}" 
                                        data-name="{{ $customer->name }}">
                                    {{ $customer->code ?? 'N/A' }} - {{ $customer->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Suppliers">
                            @foreach($suppliers as $supplier)
                                <option value="S{{ $supplier->id }}" 
                                        data-code="{{ $supplier->code ?? 'N/A' }}" 
                                        data-name="{{ $supplier->name }}">
                                    {{ $supplier->code ?? 'N/A' }} - {{ $supplier->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <!-- Party Name Display -->
                <div class="ledger-header-item">
                    <label>Party Name:</label>
                    <input type="text" id="party_name_display" value="" readonly style="width: 250px; padding: 6px 8px; border: 1px solid #dee2e6; background: #f8f9fa; font-size: 14px; font-weight: bold; color: #0d6efd;">
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="ledger-header">
            <form method="GET" class="ledger-header-row">
                <div class="ledger-header-item">
                    <label>From:</label>
                    <input type="date" name="from_date" value="{{ $fromDate }}" style="width: 120px;">
                </div>
                <div class="ledger-header-item">
                    <label>To:</label>
                    <input type="date" name="to_date" value="{{ $toDate }}" style="width: 120px;">
                </div>
                <div class="ledger-header-item">
                    <button type="submit" class="btn btn-sm btn-primary">Ok</button>
                    <a href="{{ route('admin.items.stock-ledger-complete', $item) }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <!-- Opening Balance -->
        <div class="ledger-header" style="text-align: right;">
            <strong>Opening Bal: {{ number_format($openingBalance, 2) }}</strong>
        </div>

        <!-- Stock Ledger Table -->
        <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
            <table class="ledger-table" style="width: 100%; margin-bottom: 0; border-collapse: collapse; table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 8%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #e9ecef; font-weight: bold;">Trans No.</th>
                        <th style="width: 8%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #e9ecef; font-weight: bold;">Date</th>
                        <th style="width: 18%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #e9ecef; font-weight: bold;">Party Name</th>
                        <th style="width: 10%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #e9ecef; font-weight: bold;">Batch</th>
                        <th colspan="2" style="width: 14%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fff3cd; font-weight: bold;">Received</th>
                        <th colspan="2" style="width: 14%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #f8d7da; font-weight: bold;">Issued</th>
                        <th style="width: 10%; border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #e9ecef; font-weight: bold;">Balance</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #dee2e6; padding: 6px; background: #e9ecef;"></th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; background: #e9ecef;"></th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; background: #e9ecef;"></th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; background: #e9ecef;"></th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; text-align: center; background: #fff3cd; font-weight: bold;">Qty</th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; text-align: center; background: #fff3cd; font-weight: bold;">Free</th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; text-align: center; background: #f8d7da; font-weight: bold;">Qty</th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; text-align: center; background: #f8d7da; font-weight: bold;">Free</th>
                        <th style="border: 1px solid #dee2e6; padding: 6px; background: #e9ecef;"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($ledgers->count() > 0)
                        @foreach($ledgers->take(5) as $ledger)
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">{{ $ledger->trans_no ?? '-' }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">{{ $ledger->transaction_date->format('d/m/Y') }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 8px;">{{ $ledger->party_name }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">{{ $ledger->batch->batch_number ?? '-' }}</td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fffbf0;">
                                    @if(in_array($ledger->transaction_type, ['IN', 'RETURN']))
                                        {{ number_format($ledger->quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fffbf0;">
                                    @if(in_array($ledger->transaction_type, ['IN', 'RETURN']) && $ledger->free_quantity > 0)
                                        {{ number_format($ledger->free_quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fef5f5;">
                                    @if(in_array($ledger->transaction_type, ['OUT', 'ADJUSTMENT']))
                                        {{ number_format($ledger->quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fef5f5;">
                                    @if(in_array($ledger->transaction_type, ['OUT', 'ADJUSTMENT']) && $ledger->free_quantity > 0)
                                        {{ number_format($ledger->free_quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">{{ number_format($ledger->running_balance, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 20px;">No stock movements found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if($ledgers->count() > 5)
                <div style="max-height: 300px; overflow-y: auto; border-top: 2px solid #dee2e6;">
                    <table class="ledger-table" style="width: 100%; margin-bottom: 0; border-collapse: collapse; table-layout: fixed;">
                        <tbody>
                            @foreach($ledgers->skip(5) as $ledger)
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; width: 8%;">{{ $ledger->trans_no ?? '-' }}</td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; width: 8%;">{{ $ledger->transaction_date->format('d/m/Y') }}</td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; width: 18%;">{{ $ledger->party_name }}</td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; width: 10%;">{{ $ledger->batch->batch_number ?? '-' }}</td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fffbf0; width: 7%;">
                                        @if(in_array($ledger->transaction_type, ['IN', 'RETURN']))
                                            {{ number_format($ledger->quantity, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fffbf0; width: 7%;">
                                        @if(in_array($ledger->transaction_type, ['IN', 'RETURN']) && $ledger->free_quantity > 0)
                                            {{ number_format($ledger->free_quantity, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fef5f5; width: 7%;">
                                        @if(in_array($ledger->transaction_type, ['OUT', 'ADJUSTMENT']))
                                            {{ number_format($ledger->quantity, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; background: #fef5f5; width: 7%;">
                                        @if(in_array($ledger->transaction_type, ['OUT', 'ADJUSTMENT']) && $ledger->free_quantity > 0)
                                            {{ number_format($ledger->free_quantity, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold; width: 10%;">{{ number_format($ledger->running_balance, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Bottom Section -->
        <div class="ledger-footer">
            <div class="footer-section">
                <div class="footer-item">
                    <label>Sales Man:</label>
                    <input type="text" id="salesman_name" readonly>
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
                    <input type="text" id="party_address" readonly>
                </div>
            </div>

            <div class="footer-section">
                <div style="text-align: center; padding: 20px;">
                    <div style="font-weight: bold; margin-bottom: 10px;">Closing Bal:</div>
                    <div style="font-size: 18px; color: #0d6efd; font-weight: bold;">{{ number_format($closingBalance, 2) }}</div>
                </div>
            </div>

            <div class="footer-section">
                <div class="footer-item">
                    <label>User ID:</label>
                    <input type="text" value="{{ auth()->user()->name ?? '-' }}" readonly>
                </div>
                <div class="footer-item">
                    <label>Supplier Name:</label>
                    <input type="text" id="supplier_name" readonly>
                </div>
                <div class="footer-item">
                    <label>Bill No.:</label>
                    <input type="text" id="bill_number" readonly>
                </div>
                <div class="footer-item">
                    <label>Bil Date:</label>
                    <input type="text" id="bill_date" readonly>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-outline-primary" onclick="window.print()">Print</button>
            <button class="btn btn-outline-success" onclick="exportToExcel()">To Excel</button>
            <a href="{{ route('admin.items.show', $item) }}" class="btn btn-outline-secondary">Exit</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Party selection script loaded');
            
            const partyCodeSelect = document.getElementById('party_code_select');
            const partyNameDisplay = document.getElementById('party_name_display');
            
            if (!partyCodeSelect) {
                console.error('❌ Party code select not found!');
                return;
            }
            
            if (!partyNameDisplay) {
                console.error('❌ Party name display not found!');
                return;
            }
            
            console.log('✅ All elements found successfully');
            
            // Party selection change handler
            partyCodeSelect.addEventListener('change', function() {
                console.log('🔄 Dropdown changed');
                
                const selectedValue = this.value;
                console.log('Selected value:', selectedValue);
                
                // If empty selection, clear the party name
                if (!selectedValue) {
                    partyNameDisplay.value = '';
                    clearFooterFields();
                    console.log('✅ Cleared party name field');
                    return;
                }
                
                // Get the selected option
                const selectedOption = this.options[this.selectedIndex];
                console.log('Selected option:', selectedOption);
                
                // Get party name from data attribute
                const partyName = selectedOption.getAttribute('data-name');
                console.log('Party Name from data-name:', partyName);
                
                // Update party name field
                if (partyName) {
                    partyNameDisplay.value = partyName;
                    console.log('✅ Party name updated to:', partyName);
                    
                    // Visual feedback - green flash
                    partyNameDisplay.style.backgroundColor = '#d4edda';
                    partyNameDisplay.style.transition = 'background-color 0.5s ease';
                    
                    setTimeout(() => {
                        partyNameDisplay.style.backgroundColor = '#f8f9fa';
                    }, 1000);
                } else {
                    console.warn('⚠️ No party name found in data attribute');
                }
                
                // Fetch additional party details via AJAX
                const isCustomer = selectedValue.startsWith('C');
                const id = selectedValue.substring(1);
                
                console.log('Fetching details for:', isCustomer ? 'Customer' : 'Supplier', 'ID:', id);
                
                fetch(`/admin/api/party-details/${isCustomer ? 'customer' : 'supplier'}/${id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ AJAX Response:', data);
                        
                        // Update footer fields
                        const addressField = document.getElementById('party_address');
                        const supplierField = document.getElementById('supplier_name');
                        const salesmanField = document.getElementById('salesman_name');
                        
                        if (addressField && data.address) {
                            addressField.value = data.address;
                            console.log('✅ Address updated');
                        }
                        
                        if (!isCustomer && supplierField && data.name) {
                            supplierField.value = data.name;
                            console.log('✅ Supplier name updated');
                        }
                        
                        if (salesmanField && data.salesman) {
                            salesmanField.value = data.salesman;
                            console.log('✅ Salesman updated');
                        }
                    })
                    .catch(error => {
                        console.error('❌ AJAX Error:', error);
                    });
            });
            
            // Helper function to clear footer fields
            function clearFooterFields() {
                const fields = ['party_address', 'supplier_name', 'salesman_name'];
                fields.forEach(id => {
                    const field = document.getElementById(id);
                    if (field) field.value = '';
                });
            }
        });

        // Export to Excel function
        function exportToExcel() {
            const table = document.querySelector('.ledger-table');
            const csv = [];
            const rows = table.querySelectorAll('tr');
            
            rows.forEach(row => {
                const cols = row.querySelectorAll('td, th');
                const csvRow = [];
                cols.forEach(col => {
                    csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
                });
                csv.push(csvRow.join(','));
            });

            const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
            const link = document.createElement('a');
            link.setAttribute('href', encodeURI(csvContent));
            link.setAttribute('download', 'stock_ledger_{{ $item->name }}_{{ now()->format("Y-m-d") }}.csv');
            link.click();
        }
    </script>

    <style>
        @media print {
            .btn, select, .action-buttons {
                display: none !important;
            }
            table {
                font-size: 11px;
            }
        }
    </style>
@endsection