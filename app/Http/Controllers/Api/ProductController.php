<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Catalog\ProductCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductCatalogService $catalog) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->catalog->paginate($request->only(['q', 'active'])));
    }

    public function show(string $sku): JsonResponse
    {
        return response()->json($this->catalog->findBySku($sku));
    }
}
