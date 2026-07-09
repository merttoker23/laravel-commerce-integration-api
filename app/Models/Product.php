<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku', 'supplier_sku', 'name', 'description', 'price', 'currency',
        'stock_quantity', 'is_active', 'payload', 'last_synced_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'payload' => 'array',
        'last_synced_at' => 'datetime',
    ];
}
