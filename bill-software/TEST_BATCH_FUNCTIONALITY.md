# Batch Module - Quick Test Guide

## ✅ Verify Everything is Working

### **Step 1: Check Database Tables**

```bash
# Open MySQL/Database client and run:
SHOW TABLES LIKE 'batch%';
SHOW TABLES LIKE 'stock%';

# Should show:
# - batches
# - stock_ledgers
```

### **Step 2: Check Models Exist**

```bash
# In Laravel Tinker
php artisan tinker

# Test Batch model
>>> $batch = new App\Models\Batch();
>>> echo "Batch model loaded";

# Test StockLedger model
>>> $ledger = new App\Models\StockLedger();
>>> echo "StockLedger model loaded";

# Test Item relationships
>>> $item = App\Models\Item::find(1);
>>> $item->batches();  // Should work
>>> $item->getTotalQuantity();  // Should work
```

### **Step 3: Test Routes**

```bash
# Check routes are registered
php artisan route:list | grep batch

# Should show:
# - admin/batches (GET, POST, PUT, DELETE)
# - admin/batches/create (GET)
# - admin/batches/{batch} (GET, PUT, DELETE)
# - admin/batches/item/{itemId}/view (GET)
# - admin/batches/all-batches/view (GET)
# - admin/api/item-batches/{itemId} (GET)
```

### **Step 4: Test in Browser**

#### **Test 4.1: Create Batch**
```
1. Navigate to: http://localhost/bill-software/admin/batches/create
2. Fill form:
   - Item: Select any item
   - Batch Number: TEST-001
   - Manufacturing Date: 28/10/2025
   - Expiry Date: 28/10/2026
   - Quantity: 100
   - Cost Price: 50
   - Selling Price: 75
   - Godown: Godown A
3. Click "Create Batch"
4. Expected: Success message + redirected to batch list
```

#### **Test 4.2: View Batches List**
```
1. Navigate to: http://localhost/bill-software/admin/batches
2. Expected:
   - List of all batches
   - Search box working
   - Filter options working
   - Pagination working
   - Edit/Delete buttons visible
```

#### **Test 4.3: View Item Batches (EasySol Style)**
```
1. Navigate to: http://localhost/bill-software/admin/items
2. Click on any item
3. Click "Batches (F5)" button
4. Expected:
   - Item header shows (name + packing)
   - Batch table displays with all columns
   - Batch details form shows at bottom
   - Can click batch row to highlight
   - Edit/Delete buttons work
```

#### **Test 4.4: View All Batches (EasySol Style)**
```
1. Navigate to: http://localhost/bill-software/admin/batches/all-batches/view
2. Expected:
   - All batches from all items displayed
   - Search box working
   - Status filter working
   - Statistics showing (Total, Active, Expiring, Expired)
   - Pagination working
```

#### **Test 4.5: View Batch Details**
```
1. From batch list, click any batch
2. Expected:
   - Batch information displayed
   - Stock ledger entries shown
   - Edit button available
   - Delete button available
```

#### **Test 4.6: Edit Batch**
```
1. From batch list, click Edit
2. Modify any field (e.g., Quantity)
3. Click "Update Batch"
4. Expected:
   - Success message
   - Changes saved to database
```

#### **Test 4.7: Stock Ledger**
```
1. From batch details, click "Stock Ledger" link
2. Expected:
   - All stock movements for batch displayed
   - Transaction type shown (IN, OUT, etc)
   - Opening/closing quantities shown
   - Dates displayed
```

---

## 🧪 Database Verification

### **Check Batch Data**
```sql
SELECT * FROM batches LIMIT 5;

-- Should show:
-- id | item_id | batch_number | manufacturing_date | expiry_date | quantity | cost_price | selling_price | godown | status | is_deleted
```

### **Check Stock Ledger Data**
```sql
SELECT * FROM stock_ledgers LIMIT 5;

-- Should show:
-- id | item_id | batch_id | transaction_type | quantity | opening_qty | closing_qty | reference_type | transaction_date
```

### **Check Relationships**
```sql
-- Batches for Item 1
SELECT b.* FROM batches b 
WHERE b.item_id = 1 AND b.is_deleted = 0;

-- Stock ledger for Batch 1
SELECT sl.* FROM stock_ledgers sl 
WHERE sl.batch_id = 1;

-- All movements for Item 1
SELECT sl.* FROM stock_ledgers sl 
WHERE sl.item_id = 1;
```

---

## 🔍 Troubleshooting

### **Issue: Routes not found**
```bash
# Solution:
php artisan route:clear
php artisan route:cache
php artisan cache:clear
```

### **Issue: Views not loading**
```bash
# Solution:
php artisan view:clear
php artisan cache:clear
```

### **Issue: Models not found**
```bash
# Solution:
# Check namespace in controller
use App\Models\Batch;
use App\Models\StockLedger;

# Run composer autoload
composer dump-autoload
```

### **Issue: Database error**
```bash
# Solution:
# Check migrations ran
php artisan migrate:status

# Re-run migrations if needed
php artisan migrate:refresh
```

### **Issue: Relationships not working**
```bash
# Solution:
# Check foreign keys in database
SHOW CREATE TABLE batches;
SHOW CREATE TABLE stock_ledgers;

# Verify relationships in models
# Item::batches() should return hasMany(Batch::class)
# Batch::item() should return belongsTo(Item::class)
```

---

## ✅ Integration Test Checklist

- [ ] Migrations ran successfully
- [ ] Batches table exists
- [ ] Stock_ledgers table exists
- [ ] Batch model loads in Tinker
- [ ] StockLedger model loads in Tinker
- [ ] Item relationships work
- [ ] Routes registered
- [ ] Create batch page loads
- [ ] Can create batch
- [ ] Batch list displays
- [ ] Item batches view works
- [ ] All batches view works
- [ ] Search functionality works
- [ ] Filter functionality works
- [ ] Edit batch works
- [ ] Delete batch works
- [ ] Stock ledger displays
- [ ] Statistics calculate correctly
- [ ] Expiry color coding works
- [ ] Pagination works

---

## 🎯 Expected Results

### **After Creating a Batch:**
```
Database State:
├── batches table
│   └── 1 new record with all details
└── stock_ledgers table
    └── 1 new IN entry with quantity

UI State:
├── Success message shown
├── Redirected to batch list
└── New batch visible in list
```

### **After Viewing Item Batches:**
```
UI Display:
├── Item header (name + packing)
├── Batch table with all batches for item
├── Batch details form
├── Action buttons
└── History/Costing buttons
```

### **After Viewing All Batches:**
```
UI Display:
├── Search & filter form
├── All batches table
├── Statistics cards
├── Pagination
└── Action buttons
```

---

## 📊 Sample Test Data

### **Create Test Item First:**
```
Name: TEST ITEM
Company: GRAFT
HSN Code: 30049093
S.Rate: 100
MRP: 150
Cost: 70
```

### **Create Test Batch:**
```
Item: TEST ITEM
Batch Number: TEST-B001
Manufacturing Date: 28/10/2025
Expiry Date: 28/10/2026
Quantity: 500
Cost Price: 70
Selling Price: 100
Godown: Godown A
```

### **Expected Results:**
- Batch created successfully
- Stock ledger entry created (IN: 500)
- Item total quantity updated
- Batch visible in item-wise view
- Batch visible in all batches view

---

## 🚀 Next Steps After Verification

If all tests pass:
1. ✅ Batch module is fully functional
2. ✅ Ready for production use
3. ✅ Can proceed to Phase 2 (Stock Ledger Enhancement)
4. ✅ Can proceed to Phase 3 (Expiry Management)

---

**Test Date:** 2025-10-28
**Status:** Ready for Testing
