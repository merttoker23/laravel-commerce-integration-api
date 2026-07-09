<?php

use App\Http\Controllers\Api\CargoWebhookController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentWebhookController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierSyncController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{sku}', [ProductController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);

Route::post('/integrations/suppliers/demo/sync', [SupplierSyncController::class, 'sync']);
Route::post('/webhooks/payment/demo', [PaymentWebhookController::class, 'handle']);
Route::post('/webhooks/cargo/demo', [CargoWebhookController::class, 'handle']);
