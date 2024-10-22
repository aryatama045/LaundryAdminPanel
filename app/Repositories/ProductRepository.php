<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository extends Repository
{
    private $path = 'images/products/';
    public function model()
    {
        return Product::class;
    }

    public function getAllOrFindBySearch($isLatest = false)
    {
        $products = $this->model()::query()->whereNull('product_id');
        $searchKey = \request('search');

        if ($searchKey) {
            $products = $products->where('name', 'like', "%{$searchKey}%")
                ->orWhereHas('service', function ($service) use ($searchKey) {
                    $service->where('name', 'like', "%{$searchKey}%");
                })
                ->orWhere('price', 'like', "%{$searchKey}%")
                ->orWhere('discount_price', 'like', "%{$searchKey}%");
        }

        if ($isLatest) {
            $products->latest('id');
        }
        return $products->get();
    }

    public function getProductsByServiceIdAndVariantId($serviceId = null, $variantId = null, $searchKey = null)
    {
        $products = $this->model()::query()->whereNull('product_id');

        if ($serviceId) {
            $products = $products->where('service_id', $serviceId);
        }

        if ($variantId) {
            $products = $products->where('variant_id', $variantId);
        }

        if ($searchKey) {
            $products = $products->where('name', 'like', "%{$searchKey}%")
                ->orWhere('price', 'like', "%{$searchKey}%");
        }

        return $products->orderBy('order', 'asc')->isActive()->get();
    }

    public function storeByRequest(ProductRequest $request): Product
    {
        $thumbnail = (new MediaRepository())->storeByRequest(
            $request->image,
            $this->path,
            'this image for product thumbnail',
            'image'
        );

        return $this->model()::create([
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'slug' => $request->slug,
            'thumbnail_id' => $thumbnail->id,
            'service_id' => $request->service_id,
            'variant_id' => $request->variant_id,
            'discount_price' => $request->discount_price,
            'price' =>  $request->price,
            'description' => $request->description,
            'is_active' => $request->active ?? 0,
        ]);
    }

    public function updateByRequest(ProductRequest $request, Product $product): Product
    {
        if ($request->hasFile('image')) {
            (new MediaRepository())->updateByRequest(
                $request->image,
                $this->path,
                'image',
                $product->thumbnail
            );
        }
        $product->update([
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'slug' => $request->slug,
            'service_id' => $request->service_id,
            'variant_id' => $request->variant_id,
            'discount_price' => $request->discount_price,
            'price' =>  $request->price,
            'description' => $request->description,
            'is_active' => $request->active ?? 0,
        ]);
        return $product;
    }

    public function updateStatusById(Product $product): Product
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        return $product;
    }

    public function deleteProductById(Product $product): Product
    {
        $thumbnail = $product->thumbnail;
        if (Storage::exists($thumbnail->src)) {
            Storage::delete($thumbnail->src);
        }

        $product->delete();
        $thumbnail->delete();
        return $product;
    }

    public function findById($id): Product
    {
        return $this->model()::find($id);
    }
}
