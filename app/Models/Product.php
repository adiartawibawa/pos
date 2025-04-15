<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['category_id', 'name', 'slug', 'description', 'sku', 'price', 'stock', 'image'];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The sales that include the product.
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'sale_items')->withPivot('quantity', 'unit_price', 'subtotal')->withTimestamps();
    }

    /**
     * The purchases that include the product.
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class, 'purchase_items')->withPivot('quantity', 'unit_price', 'subtotal')->withTimestamps();
    }

    /**
     * Get the inventory record associated with the product.
     */
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
}
