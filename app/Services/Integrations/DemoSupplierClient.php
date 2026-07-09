<?php

namespace App\Services\Integrations;

use Illuminate\Support\Collection;

class DemoSupplierClient
{
    public function fetchProducts(): Collection
    {
        // In production this class would use Guzzle with retry, timeout and auth middleware.
        return collect([
            [
                'external_id' => 'SUP-1001',
                'sku' => 'DEMO-TSHIRT-001',
                'name' => 'Demo Cotton T-Shirt',
                'description' => 'Supplier product sample for portfolio demo.',
                'price' => 19.90,
                'currency' => 'USD',
                'stock' => 120,
                'active' => true,
            ],
            [
                'external_id' => 'SUP-1002',
                'sku' => 'DEMO-BAG-002',
                'name' => 'Demo Travel Bag',
                'description' => 'Supplier product sample with stock sync.',
                'price' => 49.00,
                'currency' => 'USD',
                'stock' => 42,
                'active' => true,
            ],
        ]);
    }
}
