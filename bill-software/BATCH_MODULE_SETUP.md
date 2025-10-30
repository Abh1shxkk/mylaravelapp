# Batch Management Module - Setup & Implementation Guide

## 📋 Overview
Complete Batch Management System for pharmacy/medical store with stock ledger tracking, expiry management, and batch-wise inventory control.

---

## ✅ What Has Been Created

### 1. **Database Migrations**
- `2025_10_28_104500_create_batches_table.php` - Batches table
- `2025_10_28_104600_create_stock_ledgers_table.php` - Stock ledger table

### 2. **Models**
- `app/Models/Batch.php` - Batch model with relationships and helper methods
- `app/Models/StockLedger.php` - Stock ledger model for tracking movements
- Updated `app/Models/Item.php` - Added batch relationships

### 3. **Controller**
- `app/Http/Controllers/Admin/BatchController.php` - Full CRUD operations

### 4. **Views**
- `resources/views/admin/batches/index.blade.php` - Batch list with search/filter
- `resources/views/admin/batches/create.blade.php` - Create new batch
- `resources/views/admin/batches/edit.blade.php` - Edit batch details
- `resources/views/admin/batches/show.blade.php` - View batch details with stock ledger

### 5. **Routes**
- Added to `routes/web.php` - All batch routes configured

---

## 🚀 Setup Instructions

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create:
- `batches` table
- `stock_ledgers` table

### Step 2: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Step 3: Access the Module
Navigate to: `http://localhost/bill-software/admin/batches`

---

## 📊 Database Structure

### Batches Table
```
id                  - Primary Key
item_id            - Foreign Key (items table)
batch_number       - Unique batch identifier
manufacturing_date - Date of manufacture
expiry_date        - Date of expiry
quantity           - Current quantity in stock
cost_price         - Cost per unit
selling_price      - Selling price per unit
godown             - Warehouse location
status             - active/expired/discontinued
remarks            - Additional notes
is_deleted         - Soft delete flag
timestamps         - created_at, updated_at
```

### Stock Ledgers Table
```
id                 - Primary Key
item_id            - Foreign Key (items table)
batch_id           - Foreign Key (batches table)
transaction_type   - IN/OUT/ADJUSTMENT/RETURN
quantity           - Transaction quantity
opening_qty        - Opening quantity
closing_qty        - Closing quantity
reference_type     - PURCHASE/SALE/ADJUSTMENT
reference_id       - Reference ID
transaction_date   - Date of transaction
godown             - Warehouse location
remarks            - Notes
created_by         - User who created entry
timestamps         - created_at, updated_at
```

---

## 🔧 Key Features

### Batch Model Methods
```php
// Check if batch is expired
$batch->isExpired()

// Get days until expiry
$batch->daysUntilExpiry()

// Check if expiring soon (within 30 days)
$batch->isExpiringsoon()

// Scopes for queries
Batch::active()              // Active batches only
Batch::expired()             // Expired batches
Batch::expiringsoon()        // Expiring within 30 days
Batch::forItem($itemId)      // Batches for specific item
Batch::inGodown($godown)     // Batches in specific godown
```

### Controller Actions
```
GET    /admin/batches              - List all batches
GET    /admin/batches/create       - Create form
POST   /admin/batches              - Store new batch
GET    /admin/batches/{batch}      - View batch details
GET    /admin/batches/{batch}/edit - Edit form
PUT    /admin/batches/{batch}      - Update batch
DELETE /admin/batches/{batch}      - Delete batch

GET    /admin/batches/{batch}/stock-ledger    - View stock movements
GET    /admin/batches/expiry/report           - Expiry report
GET    /admin/api/item-batches/{itemId}       - Get batches for item (AJAX)
```

---

## 📝 Usage Examples

### Create a New Batch
```php
$batch = Batch::create([
    'item_id' => 1,
    'batch_number' => 'BATCH-001',
    'manufacturing_date' => '2025-10-28',
    'expiry_date' => '2026-10-28',
    'quantity' => 100,
    'cost_price' => 50.00,
    'selling_price' => 75.00,
    'godown' => 'Godown A'
]);
```

### Get Item Batches
```php
$item = Item::find(1);
$batches = $item->batches()->where('status', 'active')->get();
$totalQty = $item->getTotalQuantity();
```

### Track Stock Movement
```php
StockLedger::create([
    'item_id' => 1,
    'batch_id' => 1,
    'transaction_type' => 'OUT',
    'quantity' => 10,
    'opening_qty' => 100,
    'closing_qty' => 90,
    'reference_type' => 'SALE',
    'reference_id' => 1,
    'transaction_date' => now(),
    'created_by' => auth()->id()
]);
```

### Check Expiry Status
```php
$expiredBatches = Batch::expired()->get();
$expiringSoon = Batch::expiringsoon()->get();
$activeBatches = Batch::active()->get();
```

---

## 🎨 UI Features

### Batch List Page
- Search by batch number, item name
- Filter by item, status
- Color-coded expiry status (Red=Expired, Yellow=Expiring Soon)
- Quick actions (View, Edit, Delete)
- Pagination support

### Create/Edit Batch
- Item selection with company info
- Manufacturing & expiry dates
- Quantity and pricing
- Warehouse/Godown location
- Form validation

### Batch Details Page
- Complete batch information
- Expiry status with days remaining
- Quantity and pricing summary
- Stock ledger history
- Edit and delete options

---

## 🔗 Integration Points

### With Items Module
- Each batch belongs to an item
- Item shows total quantity from all batches
- Batch creation linked from item details

### With Stock Ledger
- Automatic ledger entry on batch creation
- Manual entries for stock movements
- Complete audit trail

### With Sales Module (Future)
- Select batch during sale
- Automatic stock deduction
- FIFO batch selection

### With Purchase Module (Future)
- Create batches from purchase orders
- Update batch quantities
- Track received vs ordered

---

## 📋 Next Steps

### Phase 2: Stock Ledger Enhancement
- [ ] Automatic stock updates on purchase/sale
- [ ] Stock adjustment module
- [ ] Stock transfer between godowns
- [ ] Physical stock verification

### Phase 3: Expiry Management
- [ ] Expiry alerts and notifications
- [ ] Expiry return processing
- [ ] Expiry reports
- [ ] Batch replacement workflow

### Phase 4: Advanced Features
- [ ] Batch-wise profit analysis
- [ ] Batch movement reports
- [ ] Barcode integration
- [ ] Batch serialization

---

## 🐛 Troubleshooting

### Migration Issues
```bash
# If migration fails, check:
php artisan migrate:status

# Rollback and retry:
php artisan migrate:rollback
php artisan migrate
```

### Route Not Found
```bash
# Clear route cache:
php artisan route:clear
php artisan route:cache
```

### Model Not Found
```bash
# Check namespace in controller:
use App\Models\Batch;
use App\Models\StockLedger;
```

---

## 📞 Support

For issues or questions:
1. Check the model methods in `app/Models/Batch.php`
2. Review controller logic in `app/Http/Controllers/Admin/BatchController.php`
3. Check view files for UI customization

---

## 📄 Files Created

```
database/migrations/
  ├── 2025_10_28_104500_create_batches_table.php
  └── 2025_10_28_104600_create_stock_ledgers_table.php

app/Models/
  ├── Batch.php
  ├── StockLedger.php
  └── Item.php (updated)

app/Http/Controllers/Admin/
  └── BatchController.php

resources/views/admin/batches/
  ├── index.blade.php
  ├── create.blade.php
  ├── edit.blade.php
  └── show.blade.php

routes/
  └── web.php (updated)
```

---

**Created:** 2025-10-28
**Status:** ✅ Complete & Ready to Use
