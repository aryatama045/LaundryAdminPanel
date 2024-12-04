<?php

namespace App\Http\Controllers\Web\Products;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Import\BarangImport;
// use App\Export\BarangExport;
use Illuminate\Support\Facades\Input;
use File;
use Redirect;
use Excel;
use DB;
use PDF;

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

    public function show(Product $product)
    {
        $variants = $product->service->variants;
        $services = (new ServiceRepository())->getAll();
        return view('products.show', compact('product', 'services', 'variants'));
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


    public function Imports(Request $request)
    {

        $gudang = request('to_warehouse_id');
        $file   = $request->file('import_data');

        $array= Excel::toArray(new BarangImport, $file);

        dd($array);

        $data = [];
        foreach($array as $key => $val){

            foreach ($val as $key2 => $val2){

                if(isset($val2['jenis'])){
                    $slug_jenis = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $val2['jenis'])));
                    $jenis_data = JenisBarangModel::firstOrCreate(['jenisbarang_nama' => $val2['jenis'], 'jenisbarang_slug' => $slug_jenis, 'jenisbarang_ket' => '']);
                    $jenis_id   = $jenis_data->jenisbarang_id;
                }else{
                    $jenis_id = null;
                }

                if(isset($val2['kategori'])){
                    $slug_kategori  = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $val2['kategori'])));

                    $kategori       = KategoriModel::firstOrCreate(['kategori_nama' => $val2['kategori'], 'kategori_slug' => $slug_kategori, 'kategori_ket' => '']);
                    $kategori_id    = $kategori->kategori_id;
                }else{
                    $kategori_id    = null;
                }

                if(isset($val2['merk'])){
                    $slug_merk = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $val2['merk'])));
                    $merk       = MerkModel::firstOrCreate(['merk_nama' => $val2['merk'], 'merk_slug' => $slug_merk, 'merk_keterangan' => '']);
                    $merk_id    = $merk->merk_id;
                }else{
                    $merk_id    = null;
                }

                if(isset($val2['satuan'])){
                    $slug_satuan = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $val2['satuan'])));
                    $satuan_data    = SatuanModel::firstOrCreate(['satuan_nama' => $val2['satuan'], 'satuan_slug' => $slug_satuan, 'satuan_keterangan' => '']);
                    $satuan_id      = $satuan_data->satuan_id;
                }else{
                    $satuan_id      = null;
                }

                $product        = BarangModel::firstOrNew([ 'barang_nama'=>$val2['name'] ]);

                if($val2['image'])
                    $product->barang_gambar = $val2['image'];
                else
                    $product->barang_gambar = 'image.png';


                $random = Str::random(13);

                $codeProduct = 'BRG-'.$random;
                $slug_barang = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $val2['name'])));

                $product->barang_kode       = $codeProduct;
                $product->barang_nama       = $val2['name'];
                $product->barang_slug       = $slug_barang;
                $product->jenisbarang_id    = $jenis_id;
                $product->kategori_id       = $kategori_id;
                $product->merk_id           = $merk_id;
                $product->satuan_id         = $satuan_id;
                $product->barang_spek       = $val2['spek'];
                $product->barang_stok       = 0;
                $product->barang_harga      = $val2['harga'];

                $product->save();

            }

        }


        // Excel::import(new AdjustmentStokExcelImport, $request->file('file'));

        return redirect('admin/barang')->with('create_message', 'Product imported successfully');
    }

}
