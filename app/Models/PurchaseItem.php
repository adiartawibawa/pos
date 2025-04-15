<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price', 'subtotal'];

    /**
     * Get the purchase that owns the purchase item.
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the product that owns the purchase item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
