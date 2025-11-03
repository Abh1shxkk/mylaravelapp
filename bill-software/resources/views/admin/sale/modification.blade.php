@extends('layouts.admin')

@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .w-10 { width: 10%; }
  .w-15 { width: 15%; }
  .w-20 { width: 20%; }
  .w-25 { width: 25%; }
  .w-50 { width: 50%; }

  label {
    font-weight: 600;
    color: #000;
  }

  input:focus {
    box-shadow: none !important;
  }

  .fd-column {
    flex-direction: column;
  }

  .ts-amt {
    background: #f5f5f5;
  }
</style>

<div class="container-fluid p-2" style="background: #e8e8e8;">
  <form id="saleModificationForm">
    @csrf
    <!-- Top Section -->
    <div class="card mb-2">
      <div class="card-body p-2">
        <div class="row">
          <div class="col-md-4">
            <div class="card p-2">
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0">Series:</label>
                <input type="text" class="form-control w-15" name="series" style="font-size: 11px;" readonly>
              </div>
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0">Date:</label>
                <input type="date" class="form-control w-50 me-2" name="date" id="modDate" style="font-size: 11px;" onchange="updateDayName()">
                <input type="text" class="form-control border-0" id="dayName" style="font-size: 11px;" readonly>
              </div>
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0">Inv.No.:</label>
                <input type="text" class="form-control w-50" name="invoice_no" style="font-size: 11px;" readonly>
              </div>
              <div class="d-flex align-items-center">
                <label class="form-label me-2 mb-0">Due Date:</label>
                <input type="date" class="form-control w-50" name="due_date" style="font-size: 11px;">
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card p-2">
              <div class="row">
                <div class="col-9">
                  <div class="row mb-3">
                    <div class="col-md-3"><label class="form-label me-2 mb-0">Name:</label></div>
                    <div class="col-md-9">
                      <div class="d-flex align-items-center">
                        <input type="text" class="form-control w-15 me-2" style="font-size: 11px;" readonly>
                        <input type="text" class="form-control" id="customerName" style="font-size: 11px;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-3"><label class="form-label me-2 mb-0">Sales Name:</label></div>
                    <div class="col-md-9">
                      <div class="d-flex align-items-center">
                        <input type="text" class="form-control w-15 me-2" style="font-size: 11px;" readonly>
                        <input type="text" class="form-control" id="salesmanName" style="font-size: 11px;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 d-flex align-items-center justify-content-end">
                    <label class="form-label me-2 mb-0">Cash:</label>
                    <input type="text" class="form-control w-10" name="cash_type" value="N" style="font-size: 11px;" readonly>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-3 d-flex align-items-center justify-content-end">
                    <label class="form-label me-2 mb-0">Fixed Dis:</label>
                    <input type="text" class="form-control w-10" name="fixed_dis" value="N" style="font-size: 11px;">
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
        <div class="table-responsive">
          <table class="table table-bordered table-sm mb-0" style="font-size: 10px;">
            <thead style="background: #b3d9f2;">
              <tr>
                <th>Code</th>
                <th width="300">Item Name</th>
                <th>Batch</th>
                <th>Exp.</th>
                <th>Qty.</th>
                <th>F.Qty.</th>
                <th>Sale Rate</th>
                <th>Dis.%</th>
                <th>MRP</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody id="itemsTableBody">
              <tr>
                <td><input type="text" class="form-control" style="font-size: 10px;" placeholder="001"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;" placeholder="ADSILA ORGANICS PVT. LTD."></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
              </tr>
              <tr>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
                <td><input type="text" class="form-control" style="font-size: 10px;"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- HSN/Tax Section -->
        <div class="ts-tax p-3">
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
                        <input type="text" class="form-control w-25 me-2" style="font-size: 11px;">
                        <input type="text" class="form-control" style="font-size: 11px;">
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
                        <input type="text" class="form-control w-25 me-2" style="font-size: 11px;">
                        <input type="text" class="form-control" style="font-size: 11px;">
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
                      <input type="text" class="form-control" style="font-size: 11px;">
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex align-items-center fd-column mb-2">
                    <div class="me-2 d-flex align-items-center">
                      <label class="form-label mb-0 me-1 text-danger bg-danger-subtle w-100">SGST(%):</label>
                      <input type="text" class="form-control" style="font-size: 11px;">
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-flex align-items-center fd-column mb-2">
                    <div class="me-2 d-flex align-items-center">
                      <label class="form-label mb-0 me-2 text-danger bg-danger-subtle w-100">Cess(%):</label>
                      <input type="text" class="form-control" style="font-size: 11px;">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-12">
              <div class="d-flex align-items-center fd-column mb-3">
                <div class="me-2 d-flex align-items-center">
                  <label class="form-label mb-0 me-1">Tax%</label>
                  <input type="text" class="form-control" style="font-size: 11px;">
                </div>
                <div class="d-flex align-items-center">
                  <label class="form-label mb-0 me-1">Excise</label>
                  <input type="text" class="form-control" style="font-size: 11px;">
                </div>
              </div>
              <div class="d-flex align-items-center fd-column">
                <div class="me-2 d-flex align-items-center">
                  <label class="form-label mb-0 me-1">TCS</label>
                  <input type="text" class="form-control" style="font-size: 11px;">
                </div>
                <div class="d-flex align-items-center">
                  <label class="form-label mb-0 me-1">SC%</label>
                  <input type="text" class="form-control" style="font-size: 11px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Amount Section 1 -->
    <div class="card mb-2">
      <div class="card-body ts-amt">
        <div class="row gx-3 align-items-center">
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-25">SC</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">F.T.Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Dis</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-25">Tax</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Net</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.%</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Amount Section 2 -->
    <div class="card mb-2">
      <div class="card-body ts-amt">
        <div class="row gx-3 align-items-center">
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Packing</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm. %</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Sub.Tot.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Comp</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Srino</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Unit</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">SC Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Scm.Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Tax Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">SCM.</label>
                <div class="d-flex align-items-center">
                  <input type="number" class="form-control" style="font-size: 11px;" value="0">
                  <label class="form-label mx-1 mb-0 fs-4 fw-bold">+</label>
                  <input type="number" class="form-control" style="font-size: 11px;" value="0">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Cl. Qty</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Dis. Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Net Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">COST + GST</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Lctn</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">HS Amt.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-50">Vol.</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4">
            <div class="d-flex align-items-center fd-column mb-2">
              <div class="me-2 d-flex align-items-center">
                <label class="form-label mb-0 me-1 w-75">Batch Code</label>
                <input type="text" class="form-control" style="font-size: 11px;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="card">
      <div class="card-body p-2">
        <button type="submit" class="btn btn-primary btn-sm">Update (End)</button>
        <button type="button" class="btn btn-secondary btn-sm">Cancel</button>
        <button type="button" class="btn btn-info btn-sm">View On Screen</button>
        <button type="button" class="btn btn-warning btn-sm">Print</button>
      </div>
    </div>
  </form>
</div>

<script>
function updateDayName() {
  const dateInput = document.getElementById('modDate');
  const dayNameInput = document.getElementById('dayName');
  if (dateInput.value) {
    const date = new Date(dateInput.value);
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    dayNameInput.value = days[date.getDay()];
  }
}

document.getElementById('saleModificationForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Sale Modification updated successfully!');
});
</script>
@endsection
