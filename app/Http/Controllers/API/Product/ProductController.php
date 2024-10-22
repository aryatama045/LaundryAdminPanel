<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function index()
    {
        $serviceId = \request('service_id');
        $variantId = \request('variant_id');
        $searchKey = \request('search');

        $products = (new ProductRepository())
            ->getProductsByServiceIdAndVariantId($serviceId, $variantId, $searchKey);

        return $this->json('product list', [
            'products' => ProductResource::collection($products)
        ]);
    }
}
