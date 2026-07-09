<?php

namespace App\Services\Catalog;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ProductCatalogService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $cacheKey = 'products:index:' . md5(json_encode($filters));

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filters) {
            return Product::query()
                ->when($filters['q'] ?? null, fn ($query, $q) => $query->where('name', 'like', "%{$q}%"))
                ->when(isset($filters['active']), fn ($query) => $query->where('is_active', (bool) $filters['active']))
                ->orderBy('name')
                ->paginate(20);
        });
    }

    public function findBySku(string $sku): Product
    {
        return Cache::remember("products:sku:{$sku}", now()->addMinutes(10), function () use ($sku) {
            return Product::where('sku', $sku)->firstOrFail();
        });
    }
}
