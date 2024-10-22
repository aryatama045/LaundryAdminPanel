<?php

namespace App\Http\Controllers\Web\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\MediaRepository;
use App\Repositories\ProductRepository;

class SubProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepo
    ) {
    }

    public function index(Product $product)
    {
        return view('sub-product.index', compact('product'));
    }

    public function create(Product $product)
    {
        return view('sub-product.create', compact('product'));
    }

    public function store(ProductRequest $request, Product $product)
    {

        $this->productRepo->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'service_id' => $request->service_id,
            'variant_id' => $request->variant_id,
            'discount_price' => $request->discount_price,
            'price' =>  $request->price,
            'description' => $request->description,
            'product_id' => $product->id
        ]);
        return redirect()->route('product.subproduct.index', $product->id)->with('success', 'Created Successfully');
    }

    public function edit(Product $product){
        return view('sub-product.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepo->updateByRequest($request, $product);
        return redirect()->route('product.subproduct.index', $product->product_id)->with('success', 'Updated Successfully');
    }
}
