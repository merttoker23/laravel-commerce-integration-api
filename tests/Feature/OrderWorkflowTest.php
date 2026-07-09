<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_order_when_stock_is_available(): void
    {
        Product::create([
            'sku' => 'DEMO-TSHIRT-001',
            'name' => 'Demo Cotton T-Shirt',
            'price' => 19.90,
            'currency' => 'USD',
            'stock_quantity' => 10,
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/orders', [
            'customer' => ['name' => 'Jane Customer', 'email' => 'jane@example.com'],
            'items' => [['sku' => 'DEMO-TSHIRT-001', 'quantity' => 2]],
        ]);

        $response->assertCreated()->assertJsonPath('data.status', 'pending_payment');
        $this->assertDatabaseHas('products', ['sku' => 'DEMO-TSHIRT-001', 'stock_quantity' => 8]);
    }
}
