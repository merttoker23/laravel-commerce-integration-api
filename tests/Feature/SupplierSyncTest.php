<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_sync_creates_demo_products(): void
    {
        $response = $this->postJson('/api/integrations/suppliers/demo/sync');

        $response->assertOk()->assertJsonPath('data.created', 2);
        $this->assertDatabaseHas('products', ['sku' => 'DEMO-TSHIRT-001']);
        $this->assertDatabaseHas('integration_logs', ['provider' => 'demo-supplier', 'status' => 'success']);
    }
}
