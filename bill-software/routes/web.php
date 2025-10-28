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
        Route::resource('items', ItemController::class);
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
