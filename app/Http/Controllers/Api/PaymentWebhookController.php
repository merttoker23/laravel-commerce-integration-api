<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Integrations\PaymentWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __construct(private readonly PaymentWebhookService $webhooks) {}

    public function handle(Request $request): JsonResponse
    {
        $this->webhooks->handle($request->headers->all(), $request->all());

        return response()->json(['message' => 'Payment webhook accepted.']);
    }
}
