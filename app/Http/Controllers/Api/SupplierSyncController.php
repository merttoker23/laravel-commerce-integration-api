<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Integrations\DemoSupplierSyncService;
use Illuminate\Http\JsonResponse;

class SupplierSyncController extends Controller
{
    public function __construct(private readonly DemoSupplierSyncService $sync) {}

    public function sync(): JsonResponse
    {
        $result = $this->sync->syncProducts();

        return response()->json([
            'message' => 'Supplier sync completed.',
            'data' => $result,
        ]);
    }
}
