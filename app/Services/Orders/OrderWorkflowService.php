<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderWorkflowService
{
    public function create(array $payload): Order
    {
        return DB::transaction(function () use ($payload) {
            $items = collect($payload['items']);
            $skus = $items->pluck('sku')->all();
            $products = Product::whereIn('sku', $skus)->lockForUpdate()->get()->keyBy('sku');

            foreach ($items as $item) {
                $product = $products->get($item['sku']);
                if (! $product || ! $product->is_active) {
                    throw ValidationException::withMessages(['items' => "Product {$item['sku']} is not available."]);
                }
                if ($product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages(['items' => "Insufficient stock for {$item['sku']}."]);
                }
            }

            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'customer_name' => $payload['customer']['name'],
                'customer_email' => $payload['customer']['email'],
                'status' => 'pending_payment',
                'currency' => 'USD',
                'shipping_address' => $payload['shipping_address'] ?? null,
            ]);

            $subtotal = 0;
            foreach ($items as $item) {
                $product = $products->get($item['sku']);
                $lineTotal = $product->price * $item['quantity'];
                $subtotal += $lineTotal;

                $order->items()->create([
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'line_total' => $lineTotal,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }

            $order->update(['subtotal' => $subtotal]);

            return $order;
        });
    }
}
