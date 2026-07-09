<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\Orders\OrderWorkflowService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private readonly OrderWorkflowService $orders) {}

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orders->create($request->validated());

        return response()->json([
            'message' => 'Order created successfully.',
            'data' => $order->load('items'),
        ], 201);
    }
}
