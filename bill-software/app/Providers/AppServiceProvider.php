<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StockLedger;
use App\Models\Batch;
use App\Observers\StockLedgerObserver;
use App\Observers\BatchObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers for automatic data sync
        StockLedger::observe(StockLedgerObserver::class);
        Batch::observe(BatchObserver::class);
    }
}
