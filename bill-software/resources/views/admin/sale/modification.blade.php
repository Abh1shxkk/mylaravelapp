@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0">Sale Modification</h5>
    </div>
    <div class="card-body">
      <!-- Search Section -->
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Search Invoice</h6>
              <div class="row mb-2">
                <label class="col-sm-4 col-form-label">Invoice No:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="searchInvoiceNo" placeholder="Enter Invoice Number">
                </div>
              </div>
              <div class="row mb-2">
                <label class="col-sm-4 col-form-label">Date Range:</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="searchFromDate">
                </div>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="searchToDate">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 text-end">
                  <button type="button" class="btn btn-primary" onclick="searchInvoice()">
                    <i class="bi bi-search"></i> Search
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Recent Invoices</h6>
              <div class="list-group" id="recentInvoicesList">
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Invoice #7205</h6>
                    <small>23/10/2025</small>
                  </div>
                  <p class="mb-1">Customer Name - ₹15,000</p>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Invoice #7204</h6>
                    <small>22/10/2025</small>
                  </div>
                  <p class="mb-1">Customer Name - ₹12,500</p>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Invoice #7203</h6>
                    <small>21/10/2025</small>
                  </div>
                  <p class="mb-1">Customer Name - ₹18,750</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modification Form (Hidden by default) -->
      <div id="modificationForm" style="display: none;">
        <hr>
        <form id="saleModificationForm">
          @csrf
          <input type="hidden" name="invoice_id" id="invoiceId">
          
          <!-- Top Section -->
          <div class="row mb-3">
            <!-- Left Column -->
            <div class="col-md-6">
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Series:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control form-control-sm" name="series" id="series" readonly>
                </div>
              </div>
              
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Date:</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control form-control-sm" name="date" id="date" required>
                </div>
                <div class="col-sm-5">
                  <input type="text" class="form-control form-control-sm" id="dayName" readonly>
                </div>
              </div>
              
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Inv.No:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control form-control-sm" name="invoice_no" id="invoiceNo" readonly>
                </div>
              </div>
              
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Due Date:</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control form-control-sm" name="due_date" id="dueDate">
                </div>
              </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-md-6">
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Name:</label>
                <div class="col-sm-9">
                  <select class="form-select form-select-sm" name="customer_id" id="customerId" required>
                    <option value="">Select Customer</option>
                  </select>
                </div>
              </div>
              
              <div class="row mb-2">
                <label class="col-sm-3 col-form-label fw-bold">Sales Man:</label>
                <div class="col-sm-9">
                  <select class="form-select form-select-sm" name="salesman_id" id="salesmanId">
                    <option value="">Select Sales Man</option>
                  </select>
                </div>
              </div>
              
              <div class="row mb-2">
                <div class="col-sm-4">
                  <label class="form-label fw-bold">Total:</label>
                  <input type="text" class="form-control form-control-sm bg-info" name="total" id="total" readonly>
                </div>
                <div class="col-sm-4">
                  <label class="form-label fw-bold">Status:</label>
                  <select class="form-select form-select-sm" name="status" id="status">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Items Table -->
          <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm" id="modifyItemsTable">
              <thead class="table-warning">
                <tr>
                  <th style="width: 80px;">Code</th>
                  <th style="width: 200px;">Item Name</th>
                  <th style="width: 100px;">Batch</th>
                  <th style="width: 80px;">Qty.</th>
                  <th style="width: 100px;">Rate</th>
                  <th style="width: 60px;">Dis.%</th>
                  <th style="width: 100px;">Amount</th>
                  <th style="width: 50px;">Action</th>
                </tr>
              </thead>
              <tbody id="modifyItemsTableBody">
                <!-- Items will be loaded here -->
              </tbody>
            </table>
          </div>

          <!-- Action Buttons -->
          <div class="row">
            <div class="col-12">
              <div class="btn-group" role="group">
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-check-circle"></i> Update Invoice
                </button>
                <button type="button" class="btn btn-danger" onclick="deleteInvoice()">
                  <i class="bi bi-trash"></i> Delete Invoice
                </button>
                <button type="button" class="btn btn-secondary" onclick="cancelModification()">
                  <i class="bi bi-x-circle"></i> Cancel
                </button>
                <button type="button" class="btn btn-info" onclick="printInvoice()">
                  <i class="bi bi-printer"></i> Print
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function searchInvoice() {
  const invoiceNo = document.getElementById('searchInvoiceNo').value;
  
  if (!invoiceNo) {
    alert('Please enter an invoice number');
    return;
  }
  
  // Simulate loading invoice data
  loadInvoiceData(invoiceNo);
}

function loadInvoiceData(invoiceNo) {
  // Show modification form
  document.getElementById('modificationForm').style.display = 'block';
  
  // Populate form with dummy data (replace with actual API call)
  document.getElementById('invoiceId').value = '1';
  document.getElementById('series').value = 'SZ';
  document.getElementById('date').value = '2025-10-23';
  document.getElementById('dayName').value = 'Wednesday';
  document.getElementById('invoiceNo').value = invoiceNo;
  document.getElementById('dueDate').value = '2025-10-23';
  document.getElementById('total').value = '15000.00';
  
  // Load items (dummy data)
  const itemsTableBody = document.getElementById('modifyItemsTableBody');
  itemsTableBody.innerHTML = `
    <tr>
      <td><input type="text" class="form-control form-control-sm" value="ITM001" readonly></td>
      <td><input type="text" class="form-control form-control-sm" value="Sample Item 1" readonly></td>
      <td><input type="text" class="form-control form-control-sm" value="BATCH001"></td>
      <td><input type="number" class="form-control form-control-sm" value="10"></td>
      <td><input type="number" class="form-control form-control-sm" value="100.00" step="0.01"></td>
      <td><input type="number" class="form-control form-control-sm" value="5" step="0.01"></td>
      <td><input type="number" class="form-control form-control-sm" value="950.00" readonly></td>
      <td>
        <button type="button" class="btn btn-sm btn-danger">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>
  `;
}

function deleteInvoice() {
  if (confirm('Are you sure you want to delete this invoice?')) {
    alert('Invoice deleted successfully!');
    cancelModification();
  }
}

function cancelModification() {
  document.getElementById('modificationForm').style.display = 'none';
  document.getElementById('searchInvoiceNo').value = '';
}

function printInvoice() {
  alert('Print functionality will be implemented');
}

// Form submission
document.getElementById('saleModificationForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Invoice updated successfully!');
});
</script>
@endsection
