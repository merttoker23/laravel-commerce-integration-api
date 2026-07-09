<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Integrations\CargoWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CargoWebhookController extends Controller
{
    public function __construct(private readonly CargoWebhookService $webhooks) {}

    public function handle(Request $request): JsonResponse
    {
        $this->webhooks->handle($request->all());

        return response()->json(['message' => 'Cargo webhook accepted.']);
    }
}
