<?php

namespace App\Http\Controllers\Web\Products;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepo;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepo->getAllOrFindBySearch(true);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $services = (new ServiceRepository())->getActiveServices();
        return view('products.create', compact('services'));
    }

    public function store(ProductRequest $request)
    {
        if (($request->old_price != '') && ($request->old_price < $request->price)) {
            return back()->with('error', 'Discount price must be less than product price');
        }
        $this->productRepo->storeByRequest($request);

        return redirect()->route('product.index')->with('success', 'Product added successsfully');
    }

    public function edit(Product $product)
    {
        $variants = $product->service->variants;
        $services = (new ServiceRepository())->getAll();
        return view('products.edit', compact('product', 'services', 'variants'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        if (($request->old_price != '') && ($request->old_price < $request->price)) {
            return back()->with('error', 'Product price must be bigger than discount price');
        }
        $this->productRepo->updateByRequest($request, $product);
        return redirect()->route('product.index')->with('success', 'Product updated success');
    }

    public function toggleActivationStatus(Product $product)
    {
        $this->productRepo->updateStatusById($product);

        return back()->with('success', 'product status updated');
    }

    public function orderUpdate(Request $request ,Product $product)
    {

        $product->update([
            'order' => $request->position ?? 0
        ]);

        return back();
    }

    public function delete(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
