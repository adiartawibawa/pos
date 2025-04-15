<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['user_id', 'customer_id', 'invoice_number', 'total_amount', 'discount_amount', 'final_amount', 'payment_method', 'payment_status'];

    /**
     * Get the user that owns the sale (the cashier).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that owns the sale (optional).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->nullable();
    }

    /**
     * The products that belong to the sale.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sale_items')->withPivot('id', 'quantity', 'unit_price', 'subtotal')->withTimestamps();
    }

    /**
     * Get all of the sale items for the sale.
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
