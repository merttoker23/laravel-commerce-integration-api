<?php

namespace App\Services\Integrations;

use App\Models\IntegrationLog;
use App\Models\Order;

class PaymentWebhookService
{
    public function handle(array $headers, array $payload): void
    {
        $order = Order::where('order_number', $payload['order_number'] ?? null)->firstOrFail();

        if (($payload['event'] ?? '') === 'payment.succeeded') {
            $order->update([
                'status' => 'paid',
                'external_payment_id' => $payload['payment_id'] ?? null,
            ]);
        }

        IntegrationLog::create([
            'provider' => 'demo-payment',
            'type' => 'webhook',
            'status' => 'accepted',
            'external_id' => $payload['payment_id'] ?? null,
            'request_payload' => $payload,
        ]);
    }
}
