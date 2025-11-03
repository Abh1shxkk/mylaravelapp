@extends('layouts.admin')

@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  a {
    text-decoration: none;
  }

  ul,
  li {
    list-style: none;
  }

  .w-10 {
    width: 10%;
  }

  .w-15 {
    width: 15%;
  }

  .w-20 {
    width: 20%;
  }

  label {
    font-weight: 600;
    color: #000;
  }

  input:focus {
    box-shadow: none !important;
  }

  .btn-right {
    background: #7539FF;
    color: #fff;
  }

  .fd-column {
    flex-direction: column;
  }

  .ts-box1 {
    background: #f9f9f9;
  }

  .ts-tax {
    margin-top: 15px;
  }

  .ts-amt {
    background: #f5f5f5;
  }
</style>

<div class="container-fluid p-2" style="background: #e8e8e8;">
  <form id="saleTransactionForm">
    @csrf
    
    <!-- Top Section -->
    <div class="card mb-2">
      <div class="card-body p-2">
        <div class="row">
          <div class="col-md-4">
            <div class="card p-2">
              <div class="row">
                <div class="col-12">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Series:</label>
                    <input type="text" class="form-control w-15" name="series" value="SZ" style="font-size: 11px;">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Date:</label>
                    <input type="date" class="form-control w-50 me-2" name="date" id="saleDate" value="{{ date('Y-m-d') }}" style="font-size: 11px;" onchange="updateDayName()">
                    <input type="text" class="form-control border-0" id="dayName" value="{{ date('l') }}" style="font-size: 11px;" readonly>
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Inv.No.:</label>
                    <input type="text" class="form-control w-50" name="invoice_no" value="{{ $nextInvoiceNo }}" style="font-size: 11px;" readonly>
                  </div>
                  <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Due Date:</label>
                    <input type="date" class="form-control w-50" name="due_date" value="{{ date('Y-m-d') }}" style="font-size: 11px;">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card p-2">
              <div class="row">
                <div class="col-9">
                  <div class="row mb-3">
                    <div class="col-md-3 col-12">
                      <label class="form-label me-2 mb-0">Name:</label>
                    </div>
                    <div class="col-md-9 col-12">
                      <div class="d-flex align-items-center">
                        <select class="form-select w-15 me-2" name="customer_id" style="font-size: 11px;" required>
                          <option value="">Select</option>
                          @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->code ?? '' }}</option>
                          @endforeach
                        </select>
                        <input type="text" class="form-control" id="customerName" style="font-size: 11px;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-3 col-12">
                      <label class="form-label me-2 mb-0">Sales Name:</label>
                    </div>
                    <div class="col-md-9 col-12">
                      <div class="d-flex align-items-center">
                        <select class="form-select w-15 me-2" name="salesman_id" style="font-size: 11px;">
                          <option value="">Select</option>
                          @foreach($salesmen as $salesman)
                            <option value="{{ $salesman->id }}">{{ $salesman->code ?? '' }}</option>
                          @endforeach
                        </select>
                        <input type="text" class="form-control" id="salesmanName" style="font-size: 11px;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 d-flex align-items-center justify-content-end">
                    <label class="form-label me-2 mb-0">Cash:</label>
                    <select class="form-select w-10" name="cash_type" style="font-size: 11px;">
                      <option value="N" selected>N</option>
                      <option value="Y">Y</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-md-10 col-12">
                      <div class="d-flex align-items-center fd-column">
                        <div class="me-2 d-flex align-items-center">
                          <label class="form-label mb-0 me-1">DUE:</label>
                          <input type="text" class="form-control" name="due" style="font-size: 11px;" readonly value="0.00">
                        </div>
                        <div class="d-flex align-items-center me-1">
                          <label class="form-label mb-0 me-1">PDC:</label>
                          <input type="text" class="form-control" name="pdc" style="font-size: 11px;" readonly value="0.00">
                        </div>
                        <div class="d-flex align-items-center me-1">
                          <label class="form-label mb-0 me-1">TOTAL:</label>
                          <input type="text" class="form-control" name="total" style="font-size: 11px;" readonly value="0.00">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2 col-12">
                      <div class="d-flex align-items-center me-1">
                        <input type="text" class="form-control w-10" value="N" style="font-size: 11px;" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Items Table -->
    <div class="card mb-2">
      <div class="card-body p-0">
        <div class="table-responsive" style="overflow: visible;">
          <table class="table table-bordered table-sm mb-0" style="font-size: 10px;">
            <thead style="background: #b3d9f2;">
              <tr>
                <th style="width: 60px;">Code</th>
                <th style="width: 200px;">Item Name</th>
                <th style="width: 90px;">Batch</th>
                <th style="width: 60px;">Exp.</th>
                <th style="width: 50px;">Qty.</th>
                <th style="width: 50px;">F.Qty.</th>
                <th style="width: 80px;">Sale Rate</th>
                <th style="width: 50px;">Dis.%</th>
                <th style="width: 70px;">MRP</th>
                <th style="width: 90px;">Amount</th>
                <th style="width: 50px;">Action</th>
              </tr>
            </thead>
            <tbody id="itemsTableBody">
              <!-- Items will be added dynamically -->
            </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-success btn-sm mt-2" id="addItemBtn">
          <i class="bi bi-plus me-1"></i>Add Item
        </button>
      </div>
    </div>

    <!-- HSN Code & Tax Section -->
    <div class="card mb-2">
      <div class="card-body p-2" style="background: #f5f5f5;">
        <div class="hsnCode border p-3 rounded">
          <div class="tab-content">
            <div class="row">
              <div class="col-md-4 col-12">
                <div class="row">
                  <div class="col-12">
                    <div class="row mb-3">
                      <div class="col-md-2 col-12">
                        <label class="form-label me-2 mb-0">Case:</label>
                      </div>
                      <div class="col-md-10 col-12">
                        <div class="d-flex align-items-center">
                          <input type="text" class="form-control w-25 me-2" id="case_qty" name="case_qty" style="font-size: 11px;" readonly value="0">
                          <input type="text" class="form-control" style="font-size: 11px;" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="row mb-3">
                      <div class="col-md-2 col-12">
                        <label class="form-label me-2 mb-0">Box:</label>
                      </div>
                      <div class="col-md-10 col-12">
                        <div class="d-flex align-items-center">
                          <input type="text" class="form-control w-25 me-2" id="box_qty" name="box_qty" style="font-size: 11px;" readonly value="0">
                          <input type="text" class="form-control" style="font-size: 11px;" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="row">
                  <div class="col-12">
                    <div class="d-flex align-items-center fd-column mb-2">
                      <div class="me-2 d-flex align-items-center">
                        <label class="form-label mb-0 me-1 text-danger bg-danger-subtle w-100">CGST(%):</label>
                        <input type="text" class="form-control" id="cgst_display" style="font-size: 11px;" readonly value="0">
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-center fd-column mb-2">
                      <div class="me-2 d-flex align-items-center">
                        <label class="form-label mb-0 me-1 text-danger bg-danger-subtle w-100">SGST(%):</label>
                        <input type="text" class="form-control" id="sgst_display" style="font-size: 11px;" readonly value="0">
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-center fd-column mb-2">
                      <div class="me-2 d-flex align-items-center">
                        <label class="form-label mb-0 me-2 text-danger bg-danger-subtle w-100">Cess(%):</label>
                        <input type="text" class="form-control" id="cess_display" style="font-size: 11px;" readonly value="0">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="d-flex align-items-center fd-column mb-3">
                  <div class="me-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1">Tax%</label>
                    <input type="text" class="form-control" id="tax_percent" name="tax_percent" style="font-size: 11px;" readonly value="0.000">
                  </div>
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0  me-1">Excise</label>
                    <input type="text" class="form-control" id="excise" name="excise" style="font-size: 11px;" readonly value="0.00">
                  </div>
                </div>
                <div class="d-flex align-items-center fd-column">
                  <div class="me-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1">TCS</label>
                    <input type="text" class="form-control" id="tcs" name="tcs" style="font-size: 11px;" value="0.00">
                  </div>
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0  me-1">SC%</label>
                    <input type="text" class="form-control" id="sc_percent" name="sc_percent" style="font-size: 11px;" value="0.00">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Amount Section 1 -->
    <div class="card mb-2">
      <div class="card-body">
        <div class="row gx-3 align-items-center">
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                <input type="text" class="form-control" name="nt_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-25">SC</label>
                <input type="text" class="form-control" name="sc" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">F.T.Amt.</label>
                <input type="text" class="form-control" name="ft_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Dis</label>
                <input type="text" class="form-control" name="dis" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.</label>
                <input type="text" class="form-control" name="scm" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-25">Tax</label>
                <input type="text" class="form-control" name="tax" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Net</label>
                <input type="text" class="form-control" name="net" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.%</label>
                <input type="text" class="form-control" name="scm_percent" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Amount Section 2 -->
    <div class="card mb-2">
      <div class="card-body">
        <div class="row gx-3 align-items-center">
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Packing</label>
                <input type="text" class="form-control" name="packing" style="font-size: 11px;" value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                <input type="text" class="form-control" name="nt_amt_2" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm. %</label>
                <input type="text" class="form-control" name="scm_percent_2" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Sub.Tot.</label>
                <input type="text" class="form-control" name="sub_total" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Comp</label>
                <input type="text" class="form-control" name="comp" style="font-size: 11px;" value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Srino</label>
                <input type="text" class="form-control" name="srino" style="font-size: 11px;" value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Unit</label>
                <input type="text" class="form-control" name="unit" style="font-size: 11px;" value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">SC Amt.</label>
                <input type="text" class="form-control" name="sc_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.Amt.</label>
                <input type="text" class="form-control" name="scm_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Tax Amt.</label>
                <input type="text" class="form-control" name="tax_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">SCM.</label>
                <div class="d-flex align-items-center">
                  <input type="number" class="form-control" name="scm_1" style="font-size: 11px;" value="0">
                  <label class="form-label mx-1 mb-0 fs-4 fw-bold">+</label>
                  <input type="number" class="form-control" name="scm_2" style="font-size: 11px;" value="0">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Cl. Qty</label>
                <input type="text" class="form-control" name="cl_qty" style="font-size: 11px;" value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Dis. Amt.</label>
                <input type="text" class="form-control" name="dis_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Net Amt.</label>
                <input type="text" class="form-control" name="net_amt" style="font-size: 11px;" readonly value="0.00">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="card">
      <div class="card-body p-2">
        <button type="submit" class="btn btn-primary btn-sm">Save (End)</button>
        <button type="button" class="btn btn-secondary btn-sm">Del.Item</button>
        <button type="button" class="btn btn-success btn-sm">Insert Item</button>
        <button type="button" class="btn btn-info btn-sm">View On Screen</button>
        <button type="button" class="btn btn-warning btn-sm">Message</button>
        <button type="button" class="btn btn-primary btn-sm">Personal Message</button>
        <button type="button" class="btn btn-secondary btn-sm">P.Order (F7)</button>
        <button type="button" class="btn btn-info btn-sm">Modify Date (F5)</button>
        <button type="button" class="btn btn-danger btn-sm">Cancel Inv.</button>
        <button type="button" class="btn btn-success btn-sm">Copy Inv.</button>
      </div>
    </div>
  </form>
</div>

<script>
// Items data from server
let itemsData = [];
let itemIndex = -1; // Start with -1 so first item gets index 0

// Load items on page load
document.addEventListener('DOMContentLoaded', function() {
  // Load items
  fetch('{{ route("admin.sale.getItems") }}')
    .then(response => response.json())
    .then(data => {
      itemsData = data;
      console.log('Items loaded:', itemsData.length);
    })
    .catch(error => console.error('Error loading items:', error));
  
  // Add Item button handler
  const addItemBtn = document.getElementById('addItemBtn');
  if (addItemBtn) {
    addItemBtn.addEventListener('click', function(e) {
      e.preventDefault();
      addNewRow();
    });
  }

  // Customer name auto-population
  const customerSelect = document.querySelector('select[name="customer_id"]');
  const customerNameInput = document.getElementById('customerName');
  
  if (customerSelect && customerNameInput) {
    customerSelect.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const customerName = selectedOption.textContent;
      customerNameInput.value = customerName || '';
    });
  }

  // Salesman name auto-population
  const salesmanSelect = document.querySelector('select[name="salesman_id"]');
  const salesmanNameInput = document.getElementById('salesmanName');
  
  if (salesmanSelect && salesmanNameInput) {
    salesmanSelect.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const salesmanName = selectedOption.textContent;
      salesmanNameInput.value = salesmanName || '';
    });
  }
});

// Add new row
function addNewRow() {
  itemIndex++;
  const tbody = document.getElementById('itemsTableBody');
  
  const newRow = document.createElement('tr');
  newRow.setAttribute('data-row-index', itemIndex);
  newRow.style.cursor = 'pointer';
  newRow.onclick = function() { selectRow(itemIndex); };
  
  newRow.innerHTML = `
    <td class="p-0 position-relative">
      <input type="text" 
             class="form-control form-control-sm border-0 item-code-field" 
             name="items[${itemIndex}][code]" 
             id="code_${itemIndex}"
             data-row="${itemIndex}"
             style="font-size: 10px; cursor: pointer;" 
             onclick="showItemDropdown(${itemIndex})"
             readonly
             placeholder="Click to select">
      <input type="hidden" name="items[${itemIndex}][item_id]" id="item_id_${itemIndex}">
      
      <div class="item-dropdown" 
           id="dropdown_${itemIndex}" 
           style="display: none; position: fixed; z-index: 9999; background: white; border: 1px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.25); max-height: 300px; overflow-y: auto; width: 400px;">
        <div style="padding: 5px; border-bottom: 1px solid #eee; position: sticky; top: 0; background: white;">
          <input type="text" 
                 class="form-control form-control-sm" 
                 placeholder="Search by code or name..." 
                 onkeyup="filterItems(${itemIndex}, this.value)"
                 style="font-size: 10px;">
        </div>
        <div class="item-list" id="itemList_${itemIndex}"></div>
      </div>
    </td>
    <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][item_name]" id="item_name_${itemIndex}" style="font-size: 10px;" readonly></td>
    <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][batch]" id="batch_${itemIndex}" style="font-size: 10px;"></td>
    <td class="p-0"><input type="text" class="form-control form-control-sm border-0" name="items[${itemIndex}][expiry]" id="expiry_${itemIndex}" style="font-size: 10px;"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][qty]" id="qty_${itemIndex}" style="font-size: 10px;" onchange="calculateAmount(${itemIndex})"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][free_qty]" id="free_qty_${itemIndex}" style="font-size: 10px;"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][rate]" id="rate_${itemIndex}" step="0.01" style="font-size: 10px;" onchange="calculateAmount(${itemIndex})"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][discount]" id="discount_${itemIndex}" step="0.01" style="font-size: 10px;" onchange="calculateAmount(${itemIndex})"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][mrp]" id="mrp_${itemIndex}" step="0.01" style="font-size: 10px;"></td>
    <td class="p-0"><input type="number" class="form-control form-control-sm border-0" name="items[${itemIndex}][amount]" id="amount_${itemIndex}" style="font-size: 10px;" readonly></td>
    <td class="p-0 text-center">
      <button type="button" class="btn btn-danger btn-sm remove-item" onclick="deleteRow(this)" title="Delete Row" style="font-size: 9px; padding: 2px 5px;">
        <i class="bi bi-trash"></i>
      </button>
    </td>
  `;
  
  tbody.appendChild(newRow);
}

// Delete row
function deleteRow(button) {
  const row = button.closest('tr');
  row.remove();
  calculateTotal();
}

// Update day name when date changes
function updateDayName() {
  const dateInput = document.getElementById('saleDate');
  const dayNameInput = document.getElementById('dayName');
  
  if (dateInput.value) {
    const date = new Date(dateInput.value);
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    dayNameInput.value = days[date.getDay()];
  }
}

// Show item dropdown
function showItemDropdown(rowIndex) {
  // Hide all dropdowns first
  document.querySelectorAll('.item-dropdown').forEach(dd => dd.style.display = 'none');
  
  const codeInput = document.getElementById('code_' + rowIndex);
  const dropdown = document.getElementById('dropdown_' + rowIndex);
  const itemList = document.getElementById('itemList_' + rowIndex);
  
  // Position dropdown below the input field
  const rect = codeInput.getBoundingClientRect();
  dropdown.style.top = (rect.bottom + window.scrollY) + 'px';
  dropdown.style.left = rect.left + 'px';
  
  // Load items if not loaded
  if (itemsData.length === 0) {
    itemList.innerHTML = '<div style="padding: 10px; text-align: center;">Loading...</div>';
    dropdown.style.display = 'block';
    
    fetch('{{ route("admin.sale.getItems") }}')
      .then(response => response.json())
      .then(data => {
        itemsData = data;
        renderItems(rowIndex, data);
      })
      .catch(error => {
        itemList.innerHTML = '<div style="padding: 10px; color: red;">Error loading items</div>';
      });
  } else {
    renderItems(rowIndex, itemsData);
    dropdown.style.display = 'block';
  }
}

// Render items in dropdown
function renderItems(rowIndex, items) {
  const itemList = document.getElementById('itemList_' + rowIndex);
  
  if (items.length === 0) {
    itemList.innerHTML = '<div style="padding: 10px; text-align: center;">No items found</div>';
    return;
  }
  
  let html = '';
  items.forEach(item => {
    const code = item.bar_code || 'N/A';
    const name = item.name || 'Unnamed';
    const rate = item.s_rate || 0;
    const mrp = item.mrp || 0;
    
    html += `<div class="item-option" 
                  onclick="selectItem(${rowIndex}, ${item.id}, '${code}', '${name.replace(/'/g, "\\'")}', ${rate}, ${mrp})"
                  style="padding: 8px; cursor: pointer; font-size: 10px; border-bottom: 1px solid #f0f0f0;"
                  onmouseover="this.style.background='#f8f9fa'" 
                  onmouseout="this.style.background='white'">
              <strong>${code}</strong> - ${name}
            </div>`;
  });
  
  itemList.innerHTML = html;
}

// Filter items
function filterItems(rowIndex, searchText) {
  searchText = searchText.toLowerCase();
  
  const filtered = itemsData.filter(item => {
    const code = (item.bar_code || '').toLowerCase();
    const name = (item.name || '').toLowerCase();
    return code.includes(searchText) || name.includes(searchText);
  });
  
  renderItems(rowIndex, filtered);
}

// Select item
function selectItem(rowIndex, itemId, code, name, rate, mrp) {
  // Find the item in itemsData
  const item = itemsData.find(i => i.id == itemId);
  
  document.getElementById('code_' + rowIndex).value = code;
  document.getElementById('item_id_' + rowIndex).value = itemId;
  document.getElementById('item_name_' + rowIndex).value = name;
  document.getElementById('rate_' + rowIndex).value = rate;
  document.getElementById('mrp_' + rowIndex).value = mrp;
  
  // Store item data in row for later retrieval
  const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
  if (row && item) {
    row.setAttribute('data-item-id', itemId);
    row.setAttribute('data-hsn-code', item.hsn_code || '');
    row.setAttribute('data-cgst', item.cgst_percent || 0);
    row.setAttribute('data-sgst', item.sgst_percent || 0);
    row.setAttribute('data-cess', item.cess_percent || 0);
    row.setAttribute('data-case-qty', item.case_qty || 0);
    row.setAttribute('data-box-qty', item.box_qty || 0);
    
    // Update HSN details section immediately
    updateHSNDetails(item);
    
    // Highlight selected row
    document.querySelectorAll('#itemsTableBody tr').forEach(r => r.style.background = '');
    row.style.background = '#e3f2fd';
  }
  
  // Hide dropdown
  document.getElementById('dropdown_' + rowIndex).style.display = 'none';
  
  // Focus on quantity field
  document.getElementById('qty_' + rowIndex).focus();
}

// Update HSN Details Section
function updateHSNDetails(item) {
  if (!item) return;
  
  document.getElementById('hsn_code_display').textContent = item.hsn_code || '';
  document.getElementById('cgst_display').textContent = item.cgst_percent || 0;
  document.getElementById('sgst_display').textContent = item.sgst_percent || 0;
  document.getElementById('cess_display').textContent = item.cess_percent || 0;
  document.getElementById('case_qty').value = item.case_qty || 0;
  document.getElementById('box_qty').value = item.box_qty || 0;
  
  // Calculate amounts (placeholder - will be calculated based on item total)
  document.getElementById('cgst_amount').textContent = '0.00';
  document.getElementById('sgst_amount').textContent = '0.00';
  document.getElementById('cess_amount').textContent = '0.00';
  
  // Calculate total tax %
  const totalTax = parseFloat(item.cgst_percent || 0) + parseFloat(item.sgst_percent || 0) + parseFloat(item.cess_percent || 0);
  document.getElementById('tax_percent').value = totalTax.toFixed(3);
}

// Select row to show its HSN details
function selectRow(rowIndex) {
  const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
  if (!row) return;
  
  // Highlight selected row
  document.querySelectorAll('#itemsTableBody tr').forEach(r => r.style.background = '');
  row.style.background = '#e3f2fd';
  
  // Get item data from row attributes
  const itemId = row.getAttribute('data-item-id');
  if (!itemId) return;
  
  const item = {
    hsn_code: row.getAttribute('data-hsn-code'),
    cgst_percent: row.getAttribute('data-cgst'),
    sgst_percent: row.getAttribute('data-sgst'),
    cess_percent: row.getAttribute('data-cess'),
    case_qty: row.getAttribute('data-case-qty'),
    box_qty: row.getAttribute('data-box-qty')
  };
  
  updateHSNDetails(item);
}

// Calculate amount
function calculateAmount(rowIndex) {
  const qty = parseFloat(document.getElementById('qty_' + rowIndex).value) || 0;
  const rate = parseFloat(document.getElementById('rate_' + rowIndex).value) || 0;
  const discount = parseFloat(document.getElementById('discount_' + rowIndex).value) || 0;
  
  let amount = qty * rate;
  
  if (discount > 0) {
    amount = amount - (amount * discount / 100);
  }
  
  document.getElementById('amount_' + rowIndex).value = amount.toFixed(2);
  calculateTotal();
}

// Calculate total
function calculateTotal() {
  let total = 0;
  const tbody = document.getElementById('itemsTableBody');
  const rows = tbody.getElementsByTagName('tr');
  
  for (let i = 0; i < rows.length; i++) {
    const amountInput = rows[i].querySelector('input[name*="[amount]"]');
    if (amountInput) {
      const amount = parseFloat(amountInput.value) || 0;
      total += amount;
    }
  }
  
  document.querySelector('input[name="total"]').value = total.toFixed(2);
}

// Close dropdowns on outside click
document.addEventListener('click', function(e) {
  if (!e.target.closest('.item-code-field') && !e.target.closest('.item-dropdown')) {
    document.querySelectorAll('.item-dropdown').forEach(dd => dd.style.display = 'none');
  }
});

// Form submission
document.getElementById('saleTransactionForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  
  fetch('{{ route("admin.sale.transaction") }}', {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
  })
  .then(response => response.json())
  .then(data => {
    if(data.success) {
      alert('Sale Transaction saved successfully! Invoice No: ' + data.invoice_no);
      window.location.reload();
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while saving the transaction.');
  });
});
</script>
@endsection
