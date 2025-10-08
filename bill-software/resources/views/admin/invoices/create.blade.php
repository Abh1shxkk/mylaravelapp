@extends('layouts.admin')
@section('title','Create New Invoice')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Create New Invoice</h2>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Invoices
                </a>
            </div>

            <form action="{{ route('admin.invoices.store') }}" method="POST" id="invoiceForm">
                @csrf
                
                <!-- Company Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Company Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_id" class="form-label">Select Company *</label>
                                <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company Name *</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" value="{{ old('company_name') }}" readonly>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="company_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="company_email" name="company_email" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_address" class="form-label">Address</label>
                                <textarea class="form-control" id="company_address" name="company_address" rows="2" readonly></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="company_phone" name="company_phone" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_gst" class="form-label">GST Number</label>
                                <input type="text" class="form-control" id="company_gst" name="company_gst" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_id" class="form-label">Select Customer</label>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Customer Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="customer_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="customer_gst" class="form-label">GST Number</label>
                                <input type="text" class="form-control" id="customer_gst" name="customer_gst">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_address" class="form-label">Address</label>
                                <textarea class="form-control" id="customer_address" name="customer_address" rows="2"></textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="customer_state" class="form-label">State</label>
                                <input type="text" class="form-control" id="customer_state" name="customer_state">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="customer_state_code" class="form-label">State Code</label>
                                <input type="text" class="form-control" id="customer_state_code" name="customer_state_code">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Invoice Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="invoice_number" class="form-label">Invoice Number *</label>
                                <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" 
                                       id="invoice_number" name="invoice_number" value="{{ old('invoice_number', 'INV-2025-1001') }}" required>
                                <small class="form-text text-muted">Invoice number is automatically generated</small>
                                @error('invoice_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="invoice_date" class="form-label">Invoice Date *</label>
                                <input type="date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                       id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                @error('invoice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Invoice Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>HSN Code</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Rate</th>
                                        <th>Discount %</th>
                                        <th>GST %</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody">
                                    <tr>
                                        <td>
                                            <select class="form-select item-select" name="items[0][item_id]">
                                                <option value="">Select Item</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="items[0][description]" placeholder="Description"></td>
                                        <td><input type="text" class="form-control" name="items[0][hsn_code]" placeholder="HSN Code"></td>
                                        <td><input type="number" class="form-control qty" name="items[0][qty]" value="1" min="0" step="0.01"></td>
                                        <td><input type="text" class="form-control" name="items[0][unit]" placeholder="PCS"></td>
                                        <td><input type="number" class="form-control rate" name="items[0][rate]" value="0" min="0" step="0.01"></td>
                                        <td><input type="number" class="form-control discount" name="items[0][discount]" value="0" min="0" max="100" step="0.01"></td>
                                        <td><input type="number" class="form-control gst" name="items[0][gst]" value="18" min="0" max="100" step="0.01"></td>
                                        <td>
                                            <input type="text" class="form-control amount" name="items[0][amount]" value="₹0.00" readonly>
                                            <input type="hidden" class="amount_numeric" name="items[0][line_total]" value="0.00">
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-success" id="addItem">
                            <i class="bi bi-plus me-2"></i>Add Item
                        </button>
                    </div>
                </div>

                <!-- Invoice Totals -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Invoice Totals</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Subtotal:</label>
                                    <input type="text" class="form-control" id="subtotal" value="₹0.00" readonly>
                                    <input type="hidden" name="subtotal" id="subtotal_input" value="0.00">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Discount:</label>
                                    <input type="text" class="form-control" id="total_discount" value="₹0.00" readonly>
                                    <input type="hidden" name="discount_amount" id="discount_input" value="0.00">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tax Amount:</label>
                                    <input type="text" class="form-control" id="tax_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="tax_amount" id="tax_input" value="0.00">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Total Amount:</strong></label>
                                    <input type="text" class="form-control" id="total_amount" value="₹0.00" readonly>
                                    <input type="hidden" name="total_amount" id="total_input" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes for the invoice">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                                <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="3" placeholder="Payment terms and conditions">{{ old('terms_conditions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Create Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Items data keyed by id for quick lookup
const itemsData = @json($items->keyBy('id'));

document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;
    
    // Company selection handler
    document.getElementById('company_id').addEventListener('change', function() {
        const companyId = this.value;
        if (companyId) {
            // Fetch company details via AJAX
            fetch(`/admin/companies/${companyId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('company_name').value = data.name || '';
                    document.getElementById('company_email').value = data.email || '';
                    document.getElementById('company_address').value = data.address || '';
                    document.getElementById('company_phone').value = data.telephone || '';
                    document.getElementById('company_gst').value = data.tax_registration || '';
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Clear company fields
            document.getElementById('company_name').value = '';
            document.getElementById('company_email').value = '';
            document.getElementById('company_address').value = '';
            document.getElementById('company_phone').value = '';
            document.getElementById('company_gst').value = '';
        }
    });

    // Customer selection handler
    document.getElementById('customer_id').addEventListener('change', function() {
        const customerId = this.value;
        if (customerId) {
            // Fetch customer details via AJAX
            fetch(`/admin/customers/${customerId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('customer_name').value = data.name || '';
                    document.getElementById('customer_email').value = data.email || '';
                    document.getElementById('customer_phone').value = data.mobile || '';
                    document.getElementById('customer_gst').value = data.tax_registration || '';
                    document.getElementById('customer_address').value = data.address || '';
                    document.getElementById('customer_state').value = data.city || '';
                    document.getElementById('customer_state_code').value = data.state_code || '';
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Clear customer fields
            document.getElementById('customer_name').value = '';
            document.getElementById('customer_email').value = '';
            document.getElementById('customer_phone').value = '';
            document.getElementById('customer_gst').value = '';
            document.getElementById('customer_address').value = '';
            document.getElementById('customer_state').value = '';
            document.getElementById('customer_state_code').value = '';
        }
    });

    // Add item functionality
    document.getElementById('addItem').addEventListener('click', function() {
        itemIndex++;
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-select item-select" name="items[${itemIndex}][item_id]">
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][description]" placeholder="Description"></td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][hsn_code]" placeholder="HSN Code"></td>
            <td><input type="number" class="form-control qty" name="items[${itemIndex}][qty]" value="1" min="0" step="0.01"></td>
            <td><input type="text" class="form-control" name="items[${itemIndex}][unit]" placeholder="PCS"></td>
            <td><input type="number" class="form-control rate" name="items[${itemIndex}][rate]" value="0" min="0" step="0.01"></td>
            <td><input type="number" class="form-control discount" name="items[${itemIndex}][discount]" value="0" min="0" max="100" step="0.01"></td>
            <td><input type="number" class="form-control gst" name="items[${itemIndex}][gst]" value="18" min="0" max="100" step="0.01"></td>
            <td>
                <input type="text" class="form-control amount" name="items[${itemIndex}][amount]" value="₹0.00" readonly>
                <input type="hidden" class="amount_numeric" name="items[${itemIndex}][line_total]" value="0.00">
            </td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-trash"></i></button></td>
        `;
        document.getElementById('itemsTableBody').appendChild(newRow);
        attachItemEventListeners(newRow);
    });

    // Remove item functionality is attached per-row inside attachItemEventListeners

    // Attach event listeners to item row
    function attachItemEventListeners(row) {
        const itemSelect = row.querySelector('.item-select');
        if (itemSelect) {
            itemSelect.addEventListener('change', function() {
                const selectedId = this.value;
                if (selectedId && itemsData[selectedId]) {
                    const item = itemsData[selectedId];
                    const descInput = row.querySelector('input[name$="[description]"]');
                    const hsnInput = row.querySelector('input[name$="[hsn_code]"]');
                    const unitInput = row.querySelector('input[name$="[unit]"]');
                    const rateInput = row.querySelector('input.rate');

                    if (descInput) descInput.value = item.name || '';
                    if (hsnInput) hsnInput.value = item.HSNCode ?? item.hsn_code ?? '';
                    if (unitInput) unitInput.value = item.Unit ?? item.unit ?? '';
                    // Prefer Srate then Mrp then Prate
                    const rateVal = item.Srate ?? item.Mrp ?? item.Prate ?? item.rate ?? 0;
                    if (rateInput) rateInput.value = parseFloat(rateVal) || 0;

                    calculateItemAmount(row);
                    calculateTotals();
                }
            });
        }
        const qtyInput = row.querySelector('.qty');
        const rateInput = row.querySelector('.rate');
        const discountInput = row.querySelector('.discount');
        const gstInput = row.querySelector('.gst');
        const amountInput = row.querySelector('.amount');

        [qtyInput, rateInput, discountInput, gstInput].forEach(input => {
            input.addEventListener('input', function() {
                calculateItemAmount(row);
                calculateTotals();
            });
        });

        const removeBtn = row.querySelector('.remove-item');
        if(removeBtn){
            removeBtn.addEventListener('click', function(){
                const tr = this.closest('tr');
                tr && tr.remove();
                calculateTotals();
            });
        }
    }

    // Calculate item amount
    function calculateItemAmount(row) {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;
        const gst = parseFloat(row.querySelector('.gst').value) || 0;

        const subtotal = qty * rate;
        const discountAmount = (subtotal * discount) / 100;
        const taxableAmount = subtotal - discountAmount;
        const gstAmount = (taxableAmount * gst) / 100;
        const total = taxableAmount + gstAmount;

        row.querySelector('.amount').value = `₹${total.toFixed(2)}`;
        const amtNum = row.querySelector('.amount_numeric');
        if (amtNum) amtNum.value = total.toFixed(2);
    }

    // Calculate totals
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalGst = 0;

        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            const gst = parseFloat(row.querySelector('.gst').value) || 0;

            const itemSubtotal = qty * rate;
            const itemDiscount = (itemSubtotal * discount) / 100;
            const taxableAmount = itemSubtotal - itemDiscount;
            const itemGst = (taxableAmount * gst) / 100;

            subtotal += itemSubtotal;
            totalDiscount += itemDiscount;
            totalGst += itemGst;
        });

        const totalAmount = subtotal - totalDiscount + totalGst;

        document.getElementById('subtotal').value = `₹${subtotal.toFixed(2)}`;
        document.getElementById('total_discount').value = `₹${totalDiscount.toFixed(2)}`;
        document.getElementById('tax_amount').value = `₹${totalGst.toFixed(2)}`;
        document.getElementById('total_amount').value = `₹${totalAmount.toFixed(2)}`;
    // set hidden numeric inputs
    const subtotalInput = document.getElementById('subtotal_input');
    const discountInput = document.getElementById('discount_input');
    const taxInput = document.getElementById('tax_input');
    const totalInput = document.getElementById('total_input');
    if (subtotalInput) subtotalInput.value = subtotal.toFixed(2);
    if (discountInput) discountInput.value = totalDiscount.toFixed(2);
    if (taxInput) taxInput.value = totalGst.toFixed(2);
    if (totalInput) totalInput.value = totalAmount.toFixed(2);
    }

    // Pre-populate if values already selected (e.g., validation error returned)
    const preCompanyId = document.getElementById('company_id').value;
    if(preCompanyId){ document.getElementById('company_id').dispatchEvent(new Event('change')); }
    const preCustomerId = document.getElementById('customer_id').value;
    if(preCustomerId){ document.getElementById('customer_id').dispatchEvent(new Event('change')); }

    // Attach event listeners to existing rows
    document.querySelectorAll('#itemsTableBody tr').forEach(row => {
        attachItemEventListeners(row);
    });

    // Initial calculation
    calculateTotals();
});
</script>
@endpush


