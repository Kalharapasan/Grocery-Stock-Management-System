<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'sku', 'description', 'unit',
        'price', 'cost_price', 'low_stock_threshold', 'expiry_date', 'current_stock', 'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->low_stock_threshold;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && \Carbon\Carbon::parse($this->expiry_date)->isPast();
    }

    public function isExpiringSoon(int $days = 7): bool
    {
        return $this->expiry_date && 
               \Carbon\Carbon::parse($this->expiry_date)->isFuture() && 
               \Carbon\Carbon::parse($this->expiry_date)->diffInDays(now()) <= $days;
    }
}
