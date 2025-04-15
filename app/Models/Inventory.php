<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['product_id', 'stock_in', 'stock_out', 'current_stock'];

    /**
     * Get the product that owns the inventory.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
