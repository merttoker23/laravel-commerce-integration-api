<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'customer_email', 'status',
        'subtotal', 'currency', 'shipping_address', 'external_payment_id', 'external_cargo_id'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_address' => 'array',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
