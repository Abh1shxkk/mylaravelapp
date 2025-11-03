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
  .w-35 { width: 35%; }
  .w-40 { width: 40%; }
  .w-50 { width: 50%; }

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

  .ts-amt {
    background: #f5f5f5;
  }

  .ts-box1 {
    background: #f9f9f9;
  }

  .ts-tax {
    margin-top: 15px;
  }
</style>

<div class="container-fluid p-2" style="background: #e8e8e8;">
  <form id="purchaseModificationForm">
    @csrf
    
    <div class="ts-box1 border rounded p-3">
      <div class="row">
        <!-- Top Section -->
        <div class="col-12">
          <div class="row">
            <div class="col-lg-6 col-12">
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0 w-75">Bill / Ledger Date</label>
                <input type="date" class="form-control me-2" name="date" id="purchaseDate" value="{{ date('Y-m-d') }}" onchange="updateDayName()">
                <input type="text" class="form-control border-0" id="dayName" value="{{ date('l') }}" readonly>
              </div>
            </div>
            <div class="col-lg-3 col-12">
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0">Supplier:</label>
                <input type="text" class="form-control me-2" name="supplier_name" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-12">
              <div class="mb-3 d-flex align-items-center">
                <label class="form-label me-2 mb-0">Bill No.:</label>
                <input type="text" class="form-control w-15" name="bill_no">
              </div>
              <div class="d-flex align-items-center">
                <label class="form-label me-2 mb-0">Trn.No.:</label>
                <input type="text" class="form-control w-50" name="invoice_no" value="469" readonly>
              </div>
            </div>

            <div class="col-md-8 col-12">
              <div class="card p-2">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-lg-6 col-12">
                        <div class="mb-3 d-flex align-items-center">
                          <label class="form-label me-2 mb-0 w-50">Receive Date</label>
                          <input type="date" class="form-control me-2" name="receive_date" value="{{ date('Y-m-d') }}">
                        </div>
                      </div>
                      <div class="col-lg-3 col-12">
                        <div class="mb-3 d-flex align-items-center">
                          <label class="form-label me-2 mb-0">Cash:</label>
                          <input type="text" class="form-control me-2" name="cash_type" value="N">
                        </div>
                      </div>
                      <div class="col-lg-3 col-12">
                        <div class="mb-3 d-flex align-items-center">
                          <label class="form-label me-2 mb-0">Transfer:</label>
                          <input type="text" class="form-control me-2" name="transfer" value="N">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-lg-7 col-12">
                        <div class="mb-3 d-flex align-items-center">
                          <label class="form-label me-2 mb-0">Remarks:</label>
                          <input type="text" class="form-control me-2" name="remarks">
                        </div>
                      </div>
                      <div class="col-lg-5 col-12">
                        <div class="mb-3 d-flex align-items-center">
                          <label class="form-label me-2 mb-0 w-50">Due Date:</label>
                          <input type="date" class="form-control me-2" name="due_date" value="{{ date('Y-m-d') }}">
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
        <div class="col-12">
          <div class="hsnCode my-4 border p-3 rounded">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th>Code</th>
                    <th width="300">Item Name</th>
                    <th>Batch</th>
                    <th>Exp.</th>
                    <th>Qty.</th>
                    <th>F.Qty.</th>
                    <th>Pur. Rate</th>
                    <th>Dis.%</th>
                    <th>MRP</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="itemsTableBody">
                  <tr>
                    <td><input type="text" class="form-control" placeholder="001"></td>
                    <td><input type="text" class="form-control" placeholder="ADSILA ORGANICS PVT. LTD."></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Tax Section -->
            <div class="ts-tax">
              <div class="row">
                <div class="col-md-2">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0 w-50">SC%:</label>
                    <input type="text" class="form-control me-2" name="sc_percent">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 text-danger bg-danger-subtle w-100">CGST(%):</label>
                    <input type="text" class="form-control" name="cgst_percent">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 text-danger bg-danger-subtle w-100">SGST(%):</label>
                    <input type="text" class="form-control" name="sgst_percent">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-2 text-danger bg-danger-subtle w-100">Cess(%):</label>
                    <input type="text" class="form-control" name="cess_percent">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-40">Spl.Rate</label>
                    <input type="text" class="form-control" name="spl_rate">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-40">W.S.Rate.</label>
                    <input type="text" class="form-control" name="ws_rate">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-40">Tax%</label>
                    <input type="text" class="form-control" name="tax_percent">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-40">Inc.</label>
                    <input type="text" class="form-control me-2" name="inc">
                    <label class="form-label mb-0 me-1">S.Rate</label>
                    <input type="text" class="form-control" name="s_rate">
                  </div>
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-1">Excise</label>
                    <input type="text" class="form-control" name="excise">
                  </div>
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-40">MRP</label>
                    <input type="text" class="form-control me-2" name="mrp">
                    <label class="form-label mb-0 me-1">Less</label>
                    <input type="text" class="form-control" name="less">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Amount Section 1 -->
        <div class="col-12 mb-4">
          <div class="card ts-amt">
            <div class="card-body">
              <div class="row gx-3">
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                    <input type="text" class="form-control" name="nt_amt">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-25">SC</label>
                    <input type="text" class="form-control" name="sc">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">SCM.</label>
                    <input type="text" class="form-control" name="scm">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">DIS.</label>
                    <input type="text" class="form-control" name="dis">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">LESS</label>
                    <input type="text" class="form-control" name="less_amt">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-25">Tax</label>
                    <input type="text" class="form-control" name="tax">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">NET AMT.</label>
                    <input type="text" class="form-control" name="net_amt">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Scm.%</label>
                    <input type="text" class="form-control" name="scm_percent_1">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">TCS</label>
                    <input type="text" class="form-control" name="tcs">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Dis1 Amt</label>
                    <input type="text" class="form-control" name="dis1_amt">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">TOF</label>
                    <input type="text" class="form-control" name="tof">
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-2">
                  <div class="d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">INV.AMT.</label>
                    <input type="text" class="form-control text-end" name="inv_amt" placeholder="0.00">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Amount Section 2 -->
        <div class="col-12 mb-4">
          <div class="card ts-amt">
            <div class="card-body">
              <div class="row gx-3">
                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Unit</label>
                    <input type="text" class="form-control" name="unit">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Lctn</label>
                    <input type="text" class="form-control" name="location">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Cl.Qty</label>
                    <input type="text" class="form-control" name="cl_qty">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Pack</label>
                    <input type="text" class="form-control" name="pack">
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">N.T.Amt.</label>
                    <input type="text" class="form-control" name="nt_amt_2">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">SC Amt.</label>
                    <input type="text" class="form-control" name="sc_amt">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Dis.Amt.</label>
                    <input type="text" class="form-control" name="dis_amt">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">HS.Amt.</label>
                    <input type="text" class="form-control" name="hs_amt">
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Scm.Amt.</label>
                    <input type="text" class="form-control" name="scm_amt">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Dis1. Amt.</label>
                    <input type="text" class="form-control" name="dis1_amt_2">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Less</label>
                    <input type="text" class="form-control" name="less_2">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Gross Amt.</label>
                    <input type="text" class="form-control" name="gross_amt">
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Tax Amt.</label>
                    <input type="text" class="form-control" name="tax_amt">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Net Amt.</label>
                    <input type="text" class="form-control" name="net_amt_2">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Comp Amt.</label>
                    <input type="text" class="form-control" name="comp_amt">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Scm%</label>
                    <input type="text" class="form-control" name="scm_percent_2">
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Cost</label>
                    <input type="text" class="form-control" name="cost">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Cost+GST</label>
                    <input type="text" class="form-control" name="cost_gst">
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Vol.</label>
                    <input type="text" class="form-control" name="vol">
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">Srl.No.</label>
                    <div class="d-flex">
                      <input type="number" class="form-control" name="srl_no_1" value="0">
                      <input type="number" class="form-control ms-1" name="srl_no_2" value="0">
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-4">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">P.SCM.</label>
                    <div class="d-flex">
                      <input type="number" class="form-control" name="p_scm_1" value="0">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">+</label>
                      <input type="number" class="form-control" name="p_scm_2" value="0">
                    </div>
                  </div>
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-50">S.SCM.</label>
                    <div class="d-flex">
                      <input type="number" class="form-control" name="s_scm_1" value="0">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">+</label>
                      <input type="number" class="form-control" name="s_scm_2" value="0">
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-2 d-flex align-items-center">
                    <label class="form-label mb-0 me-1 w-10">Dis1.%</label>
                    <div class="d-flex align-items-center">
                      <input type="number" class="form-control" name="dis1_p1">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">%</label>
                      <input type="number" class="form-control" name="dis1_p2">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">%</label>
                      <input type="number" class="form-control" name="dis1_p3">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">%</label>
                      <input type="number" class="form-control" name="dis1_p4">
                      <label class="form-label mx-1 mb-0 fs-4 fw-bold">%</label>
                      <input type="number" class="form-control" name="dis1_p5">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-12">
          <div class="row">
            <div class="col-lg-6 col-12">
              <button type="submit" class="btn btn-right mb-1"><u>U</u>pdate (End)</button>
              <button type="button" class="btn btn-right mb-1"><u>D</u>el. Item</button>
              <button type="button" class="btn btn-right mb-1"><u>I</u>nsert Item</button>
              <button type="button" class="btn btn-right mb-1">Modify Date (F5)</button>
            </div>

            <div class="col-lg-3 col-12">
              <div class="row">
                <div class="col-lg-6 col-12">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Case:</label>
                    <input type="text" class="form-control me-2" name="case_qty">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="mb-3 d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Box:</label>
                    <input type="text" class="form-control me-2" name="box_qty">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-12 text-end">
              <button type="button" class="btn btn-right mb-1"><u>C</u>ancel Bill</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function updateDayName() {
  const dateInput = document.getElementById('purchaseDate');
  const dayNameInput = document.getElementById('dayName');
  if (dateInput.value) {
    const date = new Date(dateInput.value);
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    dayNameInput.value = days[date.getDay()];
  }
}

document.getElementById('purchaseModificationForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Purchase Modification updated successfully!');
});
</script>

@endsection
