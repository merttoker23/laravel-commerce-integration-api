<?php

namespace App\Services\Integrations;

use App\Models\IntegrationLog;
use App\Models\Order;

class CargoWebhookService
{
    public function handle(array $payload): void
    {
        $order = Order::where('order_number', $payload['order_number'] ?? null)->firstOrFail();

        $order->update([
            'status' => $payload['shipment_status'] ?? $order->status,
            'external_cargo_id' => $payload['tracking_number'] ?? $order->external_cargo_id,
        ]);

        IntegrationLog::create([
            'provider' => 'demo-cargo',
            'type' => 'webhook',
            'status' => 'accepted',
            'external_id' => $payload['tracking_number'] ?? null,
            'request_payload' => $payload,
        ]);
    }
}
