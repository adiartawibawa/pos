<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['user_id', 'supplier_id', 'purchase_order_number', 'purchase_date', 'total_amount'];

    /**
     * Get the user that owns the purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supplier that owns the purchase.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * The products that belong to the purchase.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'purchase_items')->withPivot('id', 'quantity', 'unit_price', 'subtotal')->withTimestamps();
    }

    /**
     * Get all of the purchase items for the purchase.
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
