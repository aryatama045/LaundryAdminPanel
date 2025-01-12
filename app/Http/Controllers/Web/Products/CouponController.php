<?php

namespace App\Http\Controllers\Web\Products;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\NotificationManage;
use App\Models\WebSetting;
use App\Repositories\CouponRepository;
use App\Repositories\DeviceKeyRepository;
use App\Services\NotificationServices;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = (new CouponRepository())->getAll();

        return view('coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create');
    }

    public function store(CouponRequest $request)
    {
        (new CouponRepository())->storeByRequest($request);

        // if ($request->notify) {

        //     $notificationManage = NotificationManage::where('name', 'coupon_notify')->first();
        //     $keys = (new DeviceKeyRepository())->getAll()->pluck('key')->toArray();

        //     if ($notificationManage?->is_active) {
        //         $message = $notificationManage->message;
        //         (new NotificationServices($message, $keys, 'Coupon Discount'));
        //     }
        // }

        return redirect()->route('coupon.index')->with('success', 'Code is added successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        (new CouponRepository())->updateByRequest($request, $coupon);

        // if ($request->notify) {

        //     $notificationManage = NotificationManage::where('name', 'coupon_notify')->first();
        //     $keys = (new DeviceKeyRepository())->getAll()->pluck('key')->toArray();

        //     if ($notificationManage?->is_active) {
        //         $message = $notificationManage->message;
        //         (new NotificationServices($message, $keys, 'Coupon Discount'));
        //     }
        // }

        return redirect()->route('coupon.index')->with('success', 'Coupon is updated successfully.');
    }

    public function Imports(Request $request)
    {

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
