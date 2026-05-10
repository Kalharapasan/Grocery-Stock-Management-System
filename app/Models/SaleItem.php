<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'unit_price', 'subtotal'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
