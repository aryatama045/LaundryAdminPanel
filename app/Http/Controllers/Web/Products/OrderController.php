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
use App\Repositories\UserRepository;

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

    private $userRepo;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;

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

    public function dataRetur($id)
    {

        $retur = Order::find($id);

        return response()->json($retur);
    }
    
    public function retur_action(Request $request)
    {
        $id = $request->order_id;

        $getOrder = DB::table('orders')->where('id', $id)->first();

        $qty_sisa = $getOrder->qty - $request->qty;


        DB::table('orders')->where('id', $id)->update(array(
            'nomor_retur'   => $request->nomor_retur,
            'alasan_retur'  => $request->alasan_retur,
            'qty'           => $qty_sisa,
            'qty_retur'     => $request->qty,
            'tanggal_retur' => date('Y-m-d H:i:s'),
            'is_retur'      => '1',
            'order_status'  => 'Disetujui',
        ));

        return redirect()->route('order.index')->with('success', 'Retur successfully');
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

        $data = [];
        foreach($array as $key => $val){
            foreach ($val as $key2 => $val2){

                $tanggal_nota = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val2['tanggal_nota']);

                $getUser = $this->userRepo->findByContact($val2['nama_customer']);

                if(!$getUser){
                    $id_customer = '0';
                }else{
                    $id_customer = $getUser->id;
                }

                $data_order = array(
                    'nomor_nota'        => $val2['nomor_nota'],
                    'tanggal_nota'      => $tanggal_nota->format('Y-m-d'),
                    'customer_id'       => $id_customer,
                    'nama_customer'     => $val2['nama_customer'],
                    'nama_barang'       => $val2['nama_barang'],
                    'qty'               => $val2['qty'],
                    'satuan'            => $val2['satuan'],
                    'part_number'       => $val2['part_number'],
                    'barang_garansi'    => $val2['barang_garansi'],
                );
                // $order->save();

                // Order::create($data_order);

                Order::updateOrCreate($data_order);

                array_push($data, $data_order);

            }
        }

        return redirect('orders')->with('success', 'Pembelian imported successfully');
    }
}
