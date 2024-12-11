<?php

namespace App\Http\Controllers\Web\Products;

use App\Events\OrderMailEvent;
use App\Events\UserMailEvent;
use PDF;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeliveryCost;
use App\Models\InvoiceManage;
use App\Models\NotificationManage;
use App\Models\WebSetting;
use App\Repositories\DeviceKeyRepository;
use App\Repositories\DriverRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Services\NotificationServices;

use Illuminate\Support\Str;
use App\Import\BarangImport;
use Illuminate\Support\Facades\Input;
use File;
use Redirect;
use Excel;
use DB;

class OrderController extends Controller
{
    private $orderRepo;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepo = $orderRepository;
    }

    public function index(Request $request)
    {
        $orders = $this->orderRepo->getSortedByRequest($request);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $quantity = 0;
        foreach ($order->products as $product) {
            $quantity += $product->pivot->quantity;
        }

        $drivers = (new DriverRepository())->getAll();
        $order->update([
            'is_show' => true
        ]);
        return view('orders.show', compact('order', 'quantity', 'drivers'));
    }

    public function statusUpdate(Order $order)
    {
        $status = config('enums.order_status.' . request('status'));

        if (!in_array($status, config('enums.order_status'))) {
            return back()->with('error', 'Invalid status');
        }
        $order = $this->orderRepo->StatusUpdateByRequest($order, $status);

        $notificationOrder = NotificationManage::where('name', $status)->first();

        if ($order->customer->devices->count() && $notificationOrder->is_active) {

            $message = $notificationOrder->message;
            $keys = $order->customer->devices->pluck('key')->toArray();

            (new NotificationServices($message, $keys, 'Order Status Update'));

            (new NotificationRepository())->storeByRequest($order->customer->id, $message, 'Order status update');
        }

        // OrderMailEvent::dispatch($order);

        return back()->with('success', 'Status updated successfully');
    }

    public function orderPaid(Order $order)
    {
        $order->update([
            'payment_status' => config('enums.payment_status.paid')
        ]);
        return back()->with('success', 'Order payment paid successfully');
    }

    public function printLabels(Order $order)
    {
        $productLabels = collect([]);
        $t = 1;
        foreach ($order->products as $key => $product) {
            for ($i = 0; $i < $product->pivot->quantity; $i++) {
                $productLabels[]    = [
                    'name' => $order->customer->user->name,
                    'code' => $order->prefix . $order->order_code,
                    'date' => Carbon::parse($order->delivery_at)->format('M d, Y'),
                    'title' => $product->name,
                    'label' => $t . '/' . \request('quantity'),
                ];
                $t++;
            }
        }

        $labels = [];
        $i = 0;
        $r = 0;

        foreach ($productLabels as $key => $label) {
            if ($key + 1 == 1 || $key + 1 == $i) {
                $labels[$r] = [];
                $i = $key + 1 == 1 ? $i + 4 : $i + 3;
                $r++;
            }
            $labels[$r - 1][] = $label;
        }

        $pdf = PDF::loadView('pdf.generate-label', compact('labels'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('labels_' . now()->format('H-i-s') . '.pdf');
    }

    public function printInvioce(Order $order)
    {
        $quantity = 0;
        foreach ($order->products as $product) {
            $quantity += $product->pivot->quantity;
        }

        $deliveryCost = DeliveryCost::first();
        $webSetting = WebSetting::first();
        $invoice = InvoiceManage::first();

        if (!$webSetting || !$webSetting->address) {
            return redirect()->route('webSetting.index')->with('error', 'Please fullfill the web setting');
        }

        if ($invoice->type == 'pos') {
            return view('pdf.posIvoice', compact('quantity', 'order', 'deliveryCost', 'webSetting'));
        }

        $pdf = PDF::loadView('pdf.invoice', compact('order', 'quantity', 'deliveryCost', 'webSetting'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($order->prefix . $order->order_code . ' - invioce.pdf');
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


        return redirect('admin/barang')->with('create_message', 'Product imported successfully');
    }
}
