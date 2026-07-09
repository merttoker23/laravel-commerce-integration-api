<?php

namespace App\Services\Integrations;

use App\Models\IntegrationLog;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Throwable;

class DemoSupplierSyncService
{
    public function __construct(private readonly DemoSupplierClient $client) {}

    public function syncProducts(): array
    {
        $created = 0;
        $updated = 0;

        try {
            foreach ($this->client->fetchProducts() as $item) {
                $product = Product::updateOrCreate(
                    ['sku' => $item['sku']],
                    [
                        'supplier_sku' => $item['external_id'],
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'currency' => $item['currency'],
                        'stock_quantity' => $item['stock'],
                        'is_active' => $item['active'],
                        'payload' => $item,
                        'last_synced_at' => now(),
                    ]
                );

                $product->wasRecentlyCreated ? $created++ : $updated++;
            }

            Cache::tags(['products'])->flush();

            IntegrationLog::create([
                'provider' => 'demo-supplier',
                'type' => 'product_sync',
                'status' => 'success',
                'response_payload' => compact('created', 'updated'),
            ]);

            return compact('created', 'updated');
        } catch (Throwable $exception) {
            IntegrationLog::create([
                'provider' => 'demo-supplier',
                'type' => 'product_sync',
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }
}
