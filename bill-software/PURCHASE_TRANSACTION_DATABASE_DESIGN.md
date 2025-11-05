# Purchase Transaction - Database Design & Implementation

## 📊 Current Flow Analysis

### Data Flow Diagram:
```
User Input (Form)
    │
    ├─► Header Data (Single Record)
    │   ├─ Bill Date
    │   ├─ Supplier ID
    │   ├─ Bill No
    │   ├─ Transaction No
    │   ├─ Receive Date
    │   ├─ Cash (Y/N)
    │   ├─ Transfer (Y/N)
    │   ├─ Remarks
    │   └─ Due Date
    │
    ├─► Items Data (Multiple Records)
    │   ├─ Item Code
    │   ├─ Item Name
    │   ├─ Batch
    │   ├─ Expiry Date
    │   ├─ Quantity
    │   ├─ Free Quantity
    │   ├─ Purchase Rate
    │   ├─ Discount %
    │   ├─ MRP
    │   └─ Amount (Calculated)
    │
    ├─► Calculated Data (Per Item)
    │   ├─ CGST Amount
    │   ├─ SGST Amount
    │   ├─ CESS Amount
    │   ├─ Tax Amount
    │   ├─ Net Amount
    │   ├─ Cost
    │   └─ Cost + GST
    │
    └─► Summary Data (Totals)
        ├─ Total NT Amount
        ├─ Total Tax
        ├─ Total Net Amount
        └─ Invoice Amount
```

---

## 🗄️ Database Schema Design

### **Approach: Master-Detail Pattern**

Ek **Purchase Transaction** mein:
- **1 Master Record** (Header data)
- **Multiple Detail Records** (Items data)

---

## 📋 Table 1: `purchase_transactions` (Master Table)

```sql
CREATE TABLE purchase_transactions (
    -- Primary Key
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    trn_no VARCHAR(50) UNIQUE NOT NULL COMMENT 'Transaction Number (Auto-generated)',
    
    -- Header Information
    bill_date DATE NOT NULL COMMENT 'Bill/Ledger Date',
    bill_no VARCHAR(100) NULL COMMENT 'Supplier Bill Number',
    supplier_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to suppliers table',
    
    -- Additional Dates
    receive_date DATE NULL COMMENT 'Material Receive Date',
    due_date DATE NULL COMMENT 'Payment Due Date',
    
    -- Payment Info
    cash_flag CHAR(1) DEFAULT 'N' COMMENT 'Cash Payment (Y/N)',
    transfer_flag CHAR(1) DEFAULT 'N' COMMENT 'Transfer Payment (Y/N)',
    
    -- Remarks
    remarks TEXT NULL COMMENT 'Transaction Remarks',
    
    -- Summary Amounts (Calculated from items)
    nt_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Total NT Amount (Sum of all items)',
    sc_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Special Commission Amount',
    scm_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Scheme Amount',
    dis_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Discount Amount',
    less_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Less Amount',
    tax_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Total Tax (CGST+SGST+CESS)',
    net_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Net Amount (NT + Tax)',
    scm_percent DECIMAL(8,3) DEFAULT 0.000 COMMENT 'Scheme Percentage',
    tcs_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'TCS Amount',
    dis1_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Discount 1 Amount',
    tof_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'TOF Amount',
    inv_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Final Invoice Amount',
    
    -- Status & Tracking
    status ENUM('draft', 'completed', 'cancelled') DEFAULT 'draft',
    order_no VARCHAR(50) NULL COMMENT 'Reference to pending order if any',
    
    -- Audit Fields
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign Keys
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id) ON DELETE RESTRICT,
    
    -- Indexes
    INDEX idx_bill_date (bill_date),
    INDEX idx_supplier (supplier_id),
    INDEX idx_trn_no (trn_no),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 📋 Table 2: `purchase_transaction_items` (Detail Table)

```sql
CREATE TABLE purchase_transaction_items (
    -- Primary Key
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    
    -- Foreign Key to Master
    purchase_transaction_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to purchase_transactions',
    
    -- Item Information
    item_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to items table',
    item_code VARCHAR(50) NOT NULL COMMENT 'Item Code (for reference)',
    item_name VARCHAR(255) NOT NULL COMMENT 'Item Name (for reference)',
    
    -- Batch & Expiry
    batch_no VARCHAR(100) NULL COMMENT 'Batch Number',
    expiry_date DATE NULL COMMENT 'Expiry Date',
    
    -- Quantities
    qty DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Purchase Quantity',
    free_qty DECIMAL(10,2) DEFAULT 0 COMMENT 'Free Quantity',
    
    -- Rates & Prices
    pur_rate DECIMAL(15,2) NOT NULL COMMENT 'Purchase Rate per unit',
    mrp DECIMAL(15,2) NULL COMMENT 'MRP',
    
    -- Discount
    dis_percent DECIMAL(8,3) DEFAULT 0.000 COMMENT 'Discount Percentage',
    
    -- Calculated Amounts
    amount DECIMAL(15,2) NOT NULL COMMENT 'Amount = (Qty × Pur.Rate) - Discount',
    
    -- GST Details (from item master but stored for history)
    cgst_percent DECIMAL(8,3) DEFAULT 0.000 COMMENT 'CGST %',
    sgst_percent DECIMAL(8,3) DEFAULT 0.000 COMMENT 'SGST %',
    cess_percent DECIMAL(8,3) DEFAULT 0.000 COMMENT 'CESS %',
    
    cgst_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'CGST Amount',
    sgst_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'SGST Amount',
    cess_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'CESS Amount',
    tax_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Total Tax (CGST+SGST+CESS)',
    
    net_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Net Amount (Amount + Tax)',
    
    -- Cost Calculations
    cost DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Cost per unit (Amount/Qty)',
    cost_gst DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Cost+GST per unit (Net/Qty)',
    
    -- Additional Fields (from detailed info section)
    unit VARCHAR(50) NULL COMMENT 'Unit',
    packing VARCHAR(100) NULL COMMENT 'Packing (e.g., 1*10)',
    company_name VARCHAR(255) NULL COMMENT 'Company Name',
    location VARCHAR(100) NULL COMMENT 'Storage Location',
    
    -- Row Order
    row_order INT DEFAULT 0 COMMENT 'Display order in transaction',
    
    -- Audit Fields
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign Keys
    FOREIGN KEY (purchase_transaction_id) REFERENCES purchase_transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE RESTRICT,
    
    -- Indexes
    INDEX idx_transaction (purchase_transaction_id),
    INDEX idx_item (item_id),
    INDEX idx_batch (batch_no),
    INDEX idx_expiry (expiry_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🔄 Data Relationships

```
suppliers (1) ──────► (M) purchase_transactions
                            │
                            │ (1)
                            │
                            ▼
                          (M) purchase_transaction_items
                            │
                            │ (M)
                            │
                            ▼
                          (1) items
```

---

## 💾 Save Transaction Flow

### JavaScript Function (Frontend):

```javascript
function savePurchase() {
    const form = document.getElementById('purchaseForm');
    const formData = new FormData(form);
    
    // 1. Collect Header Data
    const headerData = {
        bill_date: document.getElementById('billDate').value,
        supplier_id: document.getElementById('supplierSelect').value,
        bill_no: document.getElementById('billNo').value,
        trn_no: document.getElementById('trnNo').value,
        receive_date: document.getElementById('receiveDate').value,
        cash_flag: document.getElementById('cash').value,
        transfer_flag: document.getElementById('transfer').value,
        remarks: document.getElementById('remarks').value,
        due_date: document.getElementById('dueDate').value,
        
        // Summary amounts
        nt_amount: document.getElementById('nt_amt').value,
        sc_amount: document.getElementById('sc_amt').value,
        scm_amount: document.getElementById('scm_amt').value,
        dis_amount: document.getElementById('dis_amt').value,
        less_amount: document.getElementById('less_amt').value,
        tax_amount: document.getElementById('tax_amt').value,
        net_amount: document.getElementById('net_amt').value,
        scm_percent: document.getElementById('scm_percent').value,
        tcs_amount: document.getElementById('tcs_amt').value,
        dis1_amount: document.getElementById('dis1_amt').value,
        tof_amount: document.getElementById('tof_amt').value,
        inv_amount: document.getElementById('inv_amt').value
    };
    
    // 2. Collect Items Data (only rows with data)
    const items = [];
    const rows = document.querySelectorAll('#itemsTableBody tr');
    
    rows.forEach((row, index) => {
        const itemCode = row.querySelector(`input[name="items[${index}][code]"]`)?.value;
        const itemName = row.querySelector(`input[name="items[${index}][name]"]`)?.value;
        
        // Only add rows with item code or name
        if (itemCode || itemName) {
            // Get calculated data from rowGstData
            const calculatedData = rowGstData[index] || {};
            
            items.push({
                item_code: itemCode || '',
                item_name: itemName || '',
                batch_no: row.querySelector(`input[name="items[${index}][batch]"]`)?.value || '',
                expiry_date: row.querySelector(`input[name="items[${index}][exp]"]`)?.value || null,
                qty: row.querySelector(`input[name="items[${index}][qty]"]`)?.value || 0,
                free_qty: row.querySelector(`input[name="items[${index}][free_qty]"]`)?.value || 0,
                pur_rate: row.querySelector(`input[name="items[${index}][pur_rate]"]`)?.value || 0,
                dis_percent: row.querySelector(`input[name="items[${index}][dis_percent]"]`)?.value || 0,
                mrp: row.querySelector(`input[name="items[${index}][mrp]"]`)?.value || 0,
                amount: row.querySelector(`input[name="items[${index}][amount]"]`)?.value || 0,
                
                // Calculated GST data
                cgst_percent: calculatedData.cgstPercent || 0,
                sgst_percent: calculatedData.sgstPercent || 0,
                cess_percent: calculatedData.cessPercent || 0,
                cgst_amount: calculatedData.cgstAmount || 0,
                sgst_amount: calculatedData.sgstAmount || 0,
                cess_amount: calculatedData.cessAmount || 0,
                tax_amount: calculatedData.taxAmount || 0,
                net_amount: calculatedData.netAmount || 0,
                cost: calculatedData.cost || 0,
                cost_gst: calculatedData.costGst || 0,
                
                row_order: index
            });
        }
    });
    
    // 3. Prepare final payload
    const payload = {
        header: headerData,
        items: items
    };
    
    // 4. Send to backend
    fetch('/admin/purchase/transaction/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Purchase Transaction saved successfully! TRN No: ' + data.trn_no);
            window.location.href = '/admin/purchase/transactions';
        } else {
            alert('Error: ' + (data.message || 'Failed to save'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}
```

---

## 🎯 Backend Controller (Laravel)

### Route:
```php
// routes/web.php
Route::post('/admin/purchase/transaction/store', [PurchaseTransactionController::class, 'store'])
    ->name('admin.purchase.transaction.store');
```

### Controller:
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseTransaction;
use App\Models\PurchaseTransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseTransactionController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'header.bill_date' => 'required|date',
            'header.supplier_id' => 'required|exists:suppliers,supplier_id',
            'header.bill_no' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0',
            'items.*.pur_rate' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            $headerData = $request->input('header');
            $itemsData = $request->input('items');
            
            // 1. Generate Transaction Number if not provided
            if (empty($headerData['trn_no'])) {
                $headerData['trn_no'] = $this->generateTrnNo();
            }
            
            // 2. Create Master Record
            $transaction = PurchaseTransaction::create([
                'trn_no' => $headerData['trn_no'],
                'bill_date' => $headerData['bill_date'],
                'bill_no' => $headerData['bill_no'] ?? null,
                'supplier_id' => $headerData['supplier_id'],
                'receive_date' => $headerData['receive_date'] ?? null,
                'due_date' => $headerData['due_date'] ?? null,
                'cash_flag' => $headerData['cash_flag'] ?? 'N',
                'transfer_flag' => $headerData['transfer_flag'] ?? 'N',
                'remarks' => $headerData['remarks'] ?? null,
                
                // Summary amounts
                'nt_amount' => $headerData['nt_amount'] ?? 0,
                'sc_amount' => $headerData['sc_amount'] ?? 0,
                'scm_amount' => $headerData['scm_amount'] ?? 0,
                'dis_amount' => $headerData['dis_amount'] ?? 0,
                'less_amount' => $headerData['less_amount'] ?? 0,
                'tax_amount' => $headerData['tax_amount'] ?? 0,
                'net_amount' => $headerData['net_amount'] ?? 0,
                'scm_percent' => $headerData['scm_percent'] ?? 0,
                'tcs_amount' => $headerData['tcs_amount'] ?? 0,
                'dis1_amount' => $headerData['dis1_amount'] ?? 0,
                'tof_amount' => $headerData['tof_amount'] ?? 0,
                'inv_amount' => $headerData['inv_amount'] ?? 0,
                
                'status' => 'completed',
                'created_by' => auth()->id(),
            ]);
            
            // 3. Create Detail Records (Items)
            foreach ($itemsData as $itemData) {
                // Get item_id from item_code
                $item = \App\Models\Item::where('code', $itemData['item_code'])->first();
                
                if (!$item) {
                    throw new \Exception("Item not found: " . $itemData['item_code']);
                }
                
                PurchaseTransactionItem::create([
                    'purchase_transaction_id' => $transaction->id,
                    'item_id' => $item->id,
                    'item_code' => $itemData['item_code'],
                    'item_name' => $itemData['item_name'],
                    'batch_no' => $itemData['batch_no'] ?? null,
                    'expiry_date' => $itemData['expiry_date'] ?? null,
                    'qty' => $itemData['qty'],
                    'free_qty' => $itemData['free_qty'] ?? 0,
                    'pur_rate' => $itemData['pur_rate'],
                    'mrp' => $itemData['mrp'] ?? 0,
                    'dis_percent' => $itemData['dis_percent'] ?? 0,
                    'amount' => $itemData['amount'],
                    
                    // GST data
                    'cgst_percent' => $itemData['cgst_percent'] ?? 0,
                    'sgst_percent' => $itemData['sgst_percent'] ?? 0,
                    'cess_percent' => $itemData['cess_percent'] ?? 0,
                    'cgst_amount' => $itemData['cgst_amount'] ?? 0,
                    'sgst_amount' => $itemData['sgst_amount'] ?? 0,
                    'cess_amount' => $itemData['cess_amount'] ?? 0,
                    'tax_amount' => $itemData['tax_amount'] ?? 0,
                    'net_amount' => $itemData['net_amount'] ?? 0,
                    'cost' => $itemData['cost'] ?? 0,
                    'cost_gst' => $itemData['cost_gst'] ?? 0,
                    
                    // Additional fields
                    'unit' => $item->unit ?? null,
                    'packing' => $item->packing ?? null,
                    'company_name' => $item->company->name ?? null,
                    
                    'row_order' => $itemData['row_order'] ?? 0,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Purchase transaction saved successfully',
                'trn_no' => $transaction->trn_no,
                'id' => $transaction->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Transaction Save Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    private function generateTrnNo()
    {
        $lastTransaction = PurchaseTransaction::orderBy('id', 'desc')->first();
        $nextNumber = $lastTransaction ? (intval($lastTransaction->trn_no) + 1) : 1;
        return str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
```

---

## 📝 Models

### PurchaseTransaction Model:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    protected $fillable = [
        'trn_no', 'bill_date', 'bill_no', 'supplier_id',
        'receive_date', 'due_date', 'cash_flag', 'transfer_flag',
        'remarks', 'nt_amount', 'sc_amount', 'scm_amount',
        'dis_amount', 'less_amount', 'tax_amount', 'net_amount',
        'scm_percent', 'tcs_amount', 'dis1_amount', 'tof_amount',
        'inv_amount', 'status', 'order_no', 'created_by', 'updated_by'
    ];
    
    protected $casts = [
        'bill_date' => 'date',
        'receive_date' => 'date',
        'due_date' => 'date',
        'nt_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'inv_amount' => 'decimal:2',
    ];
    
    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
    
    public function items()
    {
        return $this->hasMany(PurchaseTransactionItem::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
```

### PurchaseTransactionItem Model:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransactionItem extends Model
{
    protected $fillable = [
        'purchase_transaction_id', 'item_id', 'item_code', 'item_name',
        'batch_no', 'expiry_date', 'qty', 'free_qty', 'pur_rate',
        'mrp', 'dis_percent', 'amount', 'cgst_percent', 'sgst_percent',
        'cess_percent', 'cgst_amount', 'sgst_amount', 'cess_amount',
        'tax_amount', 'net_amount', 'cost', 'cost_gst', 'unit',
        'packing', 'company_name', 'location', 'row_order'
    ];
    
    protected $casts = [
        'expiry_date' => 'date',
        'qty' => 'decimal:2',
        'free_qty' => 'decimal:2',
        'pur_rate' => 'decimal:2',
        'amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];
    
    // Relationships
    public function transaction()
    {
        return $this->belongsTo(PurchaseTransaction::class, 'purchase_transaction_id');
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
```

---

## 🔄 Edit/Modify Transaction

### Load Transaction for Edit:
```php
public function edit($id)
{
    $transaction = PurchaseTransaction::with(['items', 'supplier'])->findOrFail($id);
    
    return view('admin.purchase.transaction', [
        'transaction' => $transaction,
        'suppliers' => Supplier::all(),
        'nextTrnNo' => $transaction->trn_no
    ]);
}
```

### Update Transaction:
```php
public function update(Request $request, $id)
{
    $transaction = PurchaseTransaction::findOrFail($id);
    
    DB::beginTransaction();
    
    try {
        // Update master record
        $transaction->update($request->input('header'));
        
        // Delete old items
        $transaction->items()->delete();
        
        // Insert new items
        foreach ($request->input('items') as $itemData) {
            // Same logic as store
            PurchaseTransactionItem::create([...]);
        }
        
        DB::commit();
        
        return response()->json(['success' => true]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
```

---

## ✅ Summary

### Tables Created:
1. ✅ `purchase_transactions` - Master table (header data)
2. ✅ `purchase_transaction_items` - Detail table (items data)

### Features:
- ✅ Master-Detail relationship
- ✅ All form fields stored
- ✅ Calculated values saved
- ✅ GST data preserved
- ✅ Transaction integrity (DB transactions)
- ✅ Edit/Modify support
- ✅ Audit trail (created_by, timestamps)

### Next Steps:
1. Create migration files
2. Create models
3. Update controller
4. Update JavaScript save function
5. Test save & retrieve
