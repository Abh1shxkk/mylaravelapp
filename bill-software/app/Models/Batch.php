<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Batch extends Model
{
    protected $fillable = [
        'item_id',
        'batch_number',
        'manufacturing_date',
        'expiry_date',
        'quantity',
        'cost_price',
        'selling_price',
        'godown',
        'status',
        'remarks',
        'is_deleted'
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiry_date' => 'date',
        'quantity' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    /**
     * Relationship with Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    /**
     * Relationship with Stock Ledger
     */
    public function stockLedgers()
    {
        return $this->hasMany(StockLedger::class, 'batch_id');
    }

    /**
     * Check if batch is expired
     */
    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return Carbon::now()->gt($this->expiry_date);
    }

    /**
     * Get days until expiry
     */
    public function daysUntilExpiry()
    {
        if (!$this->expiry_date) {
            return null;
        }
        return Carbon::now()->diffInDays($this->expiry_date, false);
    }

    /**
     * Check if batch is expiring soon (within 30 days)
     */
    public function isExpiringsoon()
    {
        $daysLeft = $this->daysUntilExpiry();
        return $daysLeft !== null && $daysLeft > 0 && $daysLeft <= 30;
    }

    /**
     * Scope to get active batches
     */
    public function scopeActive($query)
    {
        return $query->where('is_deleted', 0)->where('status', 'active');
    }

    /**
     * Scope to get expired batches
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', Carbon::now()->toDateString());
    }

    /**
     * Scope to get expiring soon batches
     */
    public function scopeExpiringsoon($query)
    {
        $thirtyDaysFromNow = Carbon::now()->addDays(30)->toDateString();
        return $query->where('expiry_date', '<=', $thirtyDaysFromNow)
                     ->where('expiry_date', '>', Carbon::now()->toDateString());
    }

    /**
     * Scope to filter by item
     */
    public function scopeForItem($query, $itemId)
    {
        return $query->where('item_id', $itemId);
    }

    /**
     * Scope to filter by godown
     */
    public function scopeInGodown($query, $godown)
    {
        return $query->where('godown', $godown);
    }
}
