<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\HsnCodeController;
use App\Http\Controllers\Admin\GeneralLedgerController;
use App\Http\Controllers\Admin\CashBankBookController;
use App\Http\Controllers\Admin\SaleLedgerController;
use App\Http\Controllers\Admin\PurchaseLedgerController;
use App\Http\Controllers\Admin\AllLedgerController;
use App\Http\Controllers\Admin\SalesManController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\AreaManagerController;
use App\Http\Controllers\Admin\RegionalManagerController;
use App\Http\Controllers\Admin\MarketingManagerController;
use App\Http\Controllers\Admin\GeneralManagerController;
use App\Http\Controllers\Admin\DivisionalManagerController;
use App\Http\Controllers\Admin\CountryManagerController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CustomerLedgerController;
use App\Http\Controllers\Admin\CustomerDueController;
use App\Http\Controllers\Admin\CustomerSpecialRateController;
use App\Http\Controllers\Admin\CustomerDiscountController;
use App\Http\Controllers\Admin\CustomerChallanController;
use App\Http\Controllers\Admin\CustomerPrescriptionController;
use App\Http\Controllers\Admin\CustomerCopyDiscountController;
use App\Http\Controllers\Admin\PersonalDirectoryController;
use App\Http\Controllers\Admin\GeneralReminderController;
use App\Http\Controllers\Admin\GeneralNotebookController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\TransportMasterController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\ProfileController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::middleware(['admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::resource('customers', CustomerController::class);
        
        // Customer Features Routes
        Route::get('customers/{customer}/ledger', [CustomerLedgerController::class, 'index'])->name('customers.ledger');
        Route::post('customers/{customer}/ledger', [CustomerLedgerController::class, 'store'])->name('customers.ledger.store');
        Route::delete('customers/{customer}/ledger/{ledger}', [CustomerLedgerController::class, 'destroy'])->name('customers.ledger.destroy');
        
        Route::get('customers/{customer}/dues', [CustomerDueController::class, 'index'])->name('customers.dues');
        Route::get('customers/{customer}/dues/expiry-list', [CustomerDueController::class, 'expiryList'])->name('customers.dues.expiry-list');
        Route::post('customers/{customer}/dues', [CustomerDueController::class, 'store'])->name('customers.dues.store');
        Route::patch('customers/{customer}/dues/{due}/payment', [CustomerDueController::class, 'updatePayment'])->name('customers.dues.payment');
        Route::delete('customers/{customer}/dues/{due}', [CustomerDueController::class, 'destroy'])->name('customers.dues.destroy');
        
        Route::get('customers/{customer}/special-rates', [CustomerSpecialRateController::class, 'index'])->name('customers.special-rates');
        Route::post('customers/{customer}/special-rates', [CustomerSpecialRateController::class, 'store'])->name('customers.special-rates.store');
        Route::put('customers/{customer}/special-rates/{rate}', [CustomerSpecialRateController::class, 'update'])->name('customers.special-rates.update');
        Route::delete('customers/{customer}/special-rates/{rate}', [CustomerSpecialRateController::class, 'destroy'])->name('customers.special-rates.destroy');
        
        Route::get('customers/{customer}/discounts', [CustomerDiscountController::class, 'index'])->name('customers.discounts');
        Route::post('customers/{customer}/discounts', [CustomerDiscountController::class, 'store'])->name('customers.discounts.store');
        Route::put('customers/{customer}/discounts/{discount}', [CustomerDiscountController::class, 'update'])->name('customers.discounts.update');
        Route::delete('customers/{customer}/discounts/{discount}', [CustomerDiscountController::class, 'destroy'])->name('customers.discounts.destroy');
        
        Route::get('customers/{customer}/challans', [CustomerChallanController::class, 'index'])->name('customers.challans');
        Route::post('customers/{customer}/challans', [CustomerChallanController::class, 'store'])->name('customers.challans.store');
        Route::patch('customers/{customer}/challans/{challan}/status', [CustomerChallanController::class, 'updateStatus'])->name('customers.challans.status');
        Route::delete('customers/{customer}/challans/{challan}', [CustomerChallanController::class, 'destroy'])->name('customers.challans.destroy');
        
        Route::get('customers/{customer}/prescriptions', [CustomerPrescriptionController::class, 'index'])->name('customers.prescriptions');
        Route::post('customers/{customer}/prescriptions', [CustomerPrescriptionController::class, 'store'])->name('customers.prescriptions.store');
        Route::put('customers/{customer}/prescriptions/{prescription}', [CustomerPrescriptionController::class, 'update'])->name('customers.prescriptions.update');
        Route::delete('customers/{customer}/prescriptions/{prescription}', [CustomerPrescriptionController::class, 'destroy'])->name('customers.prescriptions.destroy');
        
        Route::get('customers/{customer}/expiry-ledger', [CustomerLedgerController::class, 'expiryLedger'])->name('customers.expiry-ledger');
        Route::post('customers/{customer}/expiry-ledger', [CustomerLedgerController::class, 'storeExpiryLedger'])->name('customers.expiry-ledger.store');
        Route::delete('customers/{customer}/expiry-ledger/{ledger}', [CustomerLedgerController::class, 'destroyExpiryLedger'])->name('customers.expiry-ledger.destroy');
        
        Route::get('customers/{customer}/copy-discount', [CustomerCopyDiscountController::class, 'index'])->name('customers.copy-discount');
        Route::post('customers/{customer}/copy-discount', [CustomerCopyDiscountController::class, 'store'])->name('customers.copy-discount.store');
        Route::get('api/customer-discounts/{customerId}', [CustomerCopyDiscountController::class, 'getCustomerDiscounts'])->name('api.customer-discounts');
        
        Route::resource('items', ItemController::class);
        Route::get('items/{item}/stock-ledger', [ItemController::class, 'stockLedger'])->name('items.stock-ledger');
        Route::get('items/{item}/stock-ledger-complete', [ItemController::class, 'stockLedgerComplete'])->name('items.stock-ledger-complete');
        Route::get('items/{item}/pending-orders', [ItemController::class, 'pendingOrders'])->name('items.pending-orders');
        Route::post('items/{item}/pending-orders', [ItemController::class, 'storePendingOrder'])->name('items.pending-orders.store');
        Route::patch('items/{item}/pending-orders/{pendingOrder}/receive', [ItemController::class, 'receivePendingOrder'])->name('items.pending-orders.receive');
        Route::delete('items/{item}/pending-orders/{pendingOrder}', [ItemController::class, 'deletePendingOrder'])->name('items.pending-orders.delete');
        Route::get('items/{item}/godown-expiry', [ItemController::class, 'godownExpiry'])->name('items.godown-expiry');
        Route::post('items/{item}/godown-expiry', [ItemController::class, 'storeGodownExpiry'])->name('items.godown-expiry.store');
        Route::patch('items/{item}/godown-expiry/{godownExpiry}/mark-expired', [ItemController::class, 'markExpired'])->name('items.godown-expiry.mark-expired');
        Route::delete('items/{item}/godown-expiry/{godownExpiry}', [ItemController::class, 'deleteGodownExpiry'])->name('items.godown-expiry.delete');
        Route::get('items/{item}/expiry-ledger', [ItemController::class, 'expiryLedger'])->name('items.expiry-ledger');
        Route::post('items/{item}/expiry-ledger', [ItemController::class, 'storeExpiryLedger'])->name('items.expiry-ledger.store');
        Route::delete('items/{item}/expiry-ledger/{expiryLedger}', [ItemController::class, 'deleteExpiryLedger'])->name('items.expiry-ledger.delete');
        Route::resource('batches', BatchController::class);
        Route::get('batches/all-batches/view', [BatchController::class, 'allBatches'])->name('batches.all');
        Route::get('batches/item/{itemId}/view', [BatchController::class, 'itemBatches'])->name('batches.item');
        Route::get('batches/{batch}/stock-ledger', [BatchController::class, 'stockLedger'])->name('batches.stock-ledger');
        Route::get('batches/expiry/report', [BatchController::class, 'expiryReport'])->name('batches.expiry-report');
        Route::get('api/item-batches/{itemId}', [BatchController::class, 'getItemBatches'])->name('api.item-batches');
        Route::get('api/party-details/{type}/{id}', [ItemController::class, 'getPartyDetails'])->name('api.party-details');
        Route::resource('suppliers', SupplierController::class);
        Route::resource('invoices', InvoiceController::class);
        Route::resource('hsn-codes', HsnCodeController::class);
        
        // Ledger Routes
        Route::get('all-ledger', [AllLedgerController::class, 'index'])->name('all-ledger.index');
        Route::get('all-ledger/details', [AllLedgerController::class, 'getLedgerDetails'])->name('all-ledger.details');
        Route::resource('general-ledger', GeneralLedgerController::class);
        Route::resource('cash-bank-books', CashBankBookController::class);
        Route::resource('sale-ledger', SaleLedgerController::class);
        Route::resource('purchase-ledger', PurchaseLedgerController::class);
        
        // Sales & Management Routes
        Route::resource('sales-men', SalesManController::class);
        Route::resource('areas', AreaController::class)->except(['show']);
        Route::resource('routes', RouteController::class)->except(['show']);
        Route::resource('states', StateController::class)->except(['show']);
        Route::resource('area-managers', AreaManagerController::class);
        Route::resource('regional-managers', RegionalManagerController::class);
        Route::resource('marketing-managers', MarketingManagerController::class);
        Route::resource('general-managers', GeneralManagerController::class);
        Route::resource('divisional-managers', DivisionalManagerController::class);
        Route::resource('country-managers', CountryManagerController::class);
        
        // New Modules Routes
        Route::resource('personal-directory', PersonalDirectoryController::class);
        Route::resource('general-reminders', GeneralReminderController::class);
        Route::resource('general-notebook', GeneralNotebookController::class);
        Route::resource('item-category', ItemCategoryController::class);
        Route::resource('transport-master', TransportMasterController::class);
        
        // Sale Routes
        Route::get('sale/transaction', [SaleController::class, 'transaction'])->name('sale.transaction');
        Route::post('sale/transaction', [SaleController::class, 'store'])->name('sale.store');
        Route::get('sale/get-items', [SaleController::class, 'getItems'])->name('sale.getItems');
        Route::get('sale/modification', [SaleController::class, 'modification'])->name('sale.modification');
        
        Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
        Route::get('/api/countries', [CustomerController::class, 'getCountries'])->name('api.countries');
        Route::get('/api/states/{country}', [CustomerController::class, 'getStates'])->name('api.states');
        Route::get('/api/cities/{country}/{state}', [CustomerController::class, 'getCities'])->name('api.cities');
    });
    // Profile settings page
    Route::get('/profile', function () {
        return view('admin.settings.profile');
    })->name('profile.settings');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [ProfileController::class, 'showChangePassword'])->name('password.change.form');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.change');
});

// User
Route::middleware(['user'])->group(function () {
    Route::view('/user/dashboard', 'user.dashboard');
});
