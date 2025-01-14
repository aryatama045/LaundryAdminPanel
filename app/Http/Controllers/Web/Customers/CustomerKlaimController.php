<?php

namespace App\Http\Controllers\Web\Customers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MediaRepository;
use App\Repositories\CustomerKlaimRepository;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Media;
use App\Models\Customer;
use App\Models\CustomerKlaims;
use App\Models\CustomerGaransis;
use App\Models\CustomerBuktiFotos;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use DB;

use App\Repositories\CustomerGaransiRepository;
use App\Models\Coupon;
use App\Models\Order;
use App\Events\KlaimMailEvent;

use App\Models\WebSetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use DataTables;


class CustomerKlaimController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $roles   = '';
            $user_id = auth()->user();

            if($user_id){
                $roles   = $user_id['roles'][0]->name;
            }

            if($roles == 'root' ){
                $data = Order::Where('klaim_id','!=','')->get();
            }else{
                // $data = Order::where('customer_id', $user_id->id)->Where('klaim_id','!=','')->get();
                $data = Order::where('customer_id', $user_id->id)->get();
            }

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    $img = ' -- ';

                    $bukti = CustomerBuktiFotos::where('klaim_id', $row->klaim_id)->first();
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();

                    if($klaim){
                        $waktu = $this->kode_smp($klaim->waktu_pemasangan) ;
                    }else{
                        $waktu = '';
                    }

                    if($bukti){
                        $get_media = DB::table('media')->where('id', $bukti->foto_id)->first();

                        $array = array(
                            "barang_gambar" => $get_media->path,
                        );

                        $img = '<a data-effect="effect-super-scaled" data-toggle="modal" href="#Gmodaldemo8"
                        onclick=gambar(' . json_encode($array) . ')>
                        <span class="avatar avatar-lg cover-image text-center"
                        style="background: url(&quot;' . Storage::url($get_media->path) . '&quot;)
                        center center;"></span></a>
                        '. $waktu .'
                        ';
                    }

                    return $img;
                })
                ->addColumn('tanggal_nota', function ($row) {
                    $tanggal_nota = $row->tanggal_nota == '' ? '-' : date('d-m-Y', strtotime($row->tanggal_nota));
                    return $tanggal_nota;
                })
                ->addColumn('nomor_nota', function ($row) {
                    $nomor_nota = $row->nomor_nota == '' ? '-' : $row->nomor_nota;
                    return $nomor_nota;
                })
                ->addColumn('nama_customer', function ($row) {
                    $nama_customer = $row->nama_customer == '' ? '-' : $row->nama_customer;
                    return $nama_customer;
                })
                ->addColumn('nama_barang', function ($row) {
                    $nama_barang = $row->nama_barang == '' ? '-' : $row->nama_barang;
                    return $nama_barang;
                })
                ->addColumn('qty', function ($row) {
                    $qty = $row->qty == '' ? '-' : $row->qty;
                    return $qty;
                })
                ->addColumn('terproteksi', function ($row) {
                    $result = '-';
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                    if($garansi->status  == 'Disetujui'){

                        $websetting = WebSetting::first();

                        $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                        $masa_berlaku = $websetting->masa_berlaku;

                        $dateExp = strtotime('+'.$masa_berlaku.' days', strtotime($garansi->tanggal_pemasangan));
                        $dateExps = date('d-m-Y', $dateExp);

                        $paymentDate = now();
                        $paymentDate = date('Y-m-d', strtotime($paymentDate));
                        //echo $paymentDate; // echos today!
                        $contractDateBegin = date('Y-m-d', strtotime($garansi->tanggal_pemasangan));
                        $contractDateEnd = date('Y-m-d', strtotime($dateExps));

                        if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                                $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                        }else{
                            if($paymentDate <= $contractDateEnd){

                                $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
                            }else{
                                $berlaku_s ='<span class="badge badge-danger"> Berlaku : Expired </span> <br>';
                            }
                        }
                        $result =  $berlaku_s .'</br>  Sampai :<small>'.$dateExps.'</small>'  ;

                    }else if($garansi->status  == 'Diproses'){
                        $result = '<span class="text-grey"><b>Diproses</b></span>';
                    }else if($garansi->status  == 'Ditolak'){
                        $result = '<span class="text-danger"><b>Ditolak</b></span>';
                    }else{
                        $result = '<span class=""> - </span>';
                    }
                    return $result;

                })

                ->addColumn('waktu_rusak', function ($row) {
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();

                    if($klaim){
                        $result =  date('H:i',strtotime($klaim->waktu_pemasangan));
                    }else{
                        $result = '-';
                    }

                    return $result;
                })
                ->addColumn('tanggal_rusak', function ($row) {
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();

                    if($klaim){
                        $result =  date('d-m-Y', strtotime($klaim->tanggal_pemasangan));
                    }else{
                        $result = '-';
                    }
                    return $result;
                })

                ->addColumn('status', function ($row) use ($request) {
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();

                    if($klaim){
                        $result = '<span class="text-success"><i class="fa fa-check-circle"></i></span>';
                    }else{
                        $result = '-';
                    }

                    return $result;
                })
                ->addColumn('klaim_proteksi', function ($row) {

                    $klaim_proteksi = '';
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();

                    if($klaim){
                        if($klaim->status == 'Proses' || $klaim->status == 'Disetujui'){
                            $klaim_proteksi .= '<span class="text-grey text-center"><b>Sudah Klaim</b></span>';
                        }else{
                            $klaim_proteksi .= '-';
                        }
                    }else{
                        $klaim_proteksi .= '<span class="text-success text-center"><a href="'. route('klaim.edit',$row->id) .'"><b>Klik Disini Klaim</b></a></span>';
                    }

                    return $klaim_proteksi;
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $roles   = '';
                    $user_id = auth()->user();
                    if($user_id){
                        $roles   = $user_id['roles'][0]->name;
                    }

                    $kode_coupon = Coupon::where('order_id', $row->id)->first();

                    if($roles=='root'){
                        $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();
                        if($klaim){
                            if($klaim->status == 'Proses'){
                                $button .= '
                                    <a href="'.route('klaim.disetujui', $row->id) .'"
                                        class="btn btn-primary py-1 px-2">
                                        Disetujui
                                    </a>';

                                $button .= ' </br> </br>
                                    <a href="'.route('klaim.ditolak', $row->id) .'"
                                        class="btn btn-danger py-1 px-2">
                                        Ditolak
                                    </a>';
                            }

                            if($klaim->status == 'Disetujui'){
                                $button .= '</br><span class="text-success"><b>Disetujui</b></span> <br>';

                                $button .= ($kode_coupon)?'Kode : '.$kode_coupon->code:'Tidak ada kode';
                            }else if($klaim->status == 'Ditolak'){
                                $button .= '</br><span class="text-danger"><b>Ditolak</b></span>';
                            }else{
                                $button .= '</br><span class="">  </span>';
                            }
                        }else{
                            $button .= '</br><span class="">  </span>';
                        }
                    }else{
                        $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();
                        if($klaim){
                            if($klaim->status == 'Disetujui'){
                                $button .= '</br><span class="text-success"><b>Disetujui</b></span>';
                            }else if($klaim->status == 'Proses'){
                                $button .= '</br><span class="text-grey"><b>Diproses</b></span>';
                            }else if($klaim->status == 'Ditolak'){
                                $button .= '</br><span class="text-danger"><b>Ditolak</b></span>';
                            }else{
                                $button .= '</br><span class=""> - </span>';
                            }
                        }else{
                            $button .= '</br><span class="">  </span>';
                        }
                    }


                    return $button;
                })
                ->rawColumns(['action','tanggal_nota','nomor_nota','nama_customer','nama_barang','qty','terproteksi','tanggal_rusak','waktu_rusak','klaim_proteksi','img','status'])
                ->make(true);
        }



        return view('customers_klaim.index');
    }

    public function index22aa()
    {
        $dataklaims = (new CustomerKlaimRepository())->getAllOrFindBySearch();



        return view('customers_klaim.index', compact('dataklaims'));
    }

    public function show(CustomerKlaims $klaim)
    {
        return view('customers_klaim.show', [
            'klaim' => $klaim
        ]);
    }

    public function create()
    {
        $customer = Customer::get();

        $user_id = auth()->user()->id;
        $garansi  = CustomerGaransis::where('customer_id', $user_id)->get();
        return view('customers_klaim.create', compact('customer'));
    }


    public function store(Request $request)
    {
        $tgl_pasang = date('Y-m-d', strtotime($request->waktu_pemasangan));

        $dateExp = strtotime('+180 days', strtotime($tgl_pasang));
        $dateExps = date('d-m-Y', $dateExp);

        $paymentDate = now();
        $paymentDate = date('Y-m-d', strtotime($paymentDate));
        //echo $paymentDate; // echos today!
        $contractDateBegin = date('Y-m-d', strtotime($tgl_pasang));
        $contractDateEnd = date('Y-m-d', strtotime($dateExps));

        if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                $berlaku_s ='Berlaku';
        }else{
            if($paymentDate <= $contractDateEnd){

                $berlaku_s ='Berlaku';
            }else{
                $berlaku_s ='Expired';
            }
        }

        if($berlaku_s == 'Expired'){
            return redirect()->route('klaim.create')->with('error', ' Tanggal Pemasangan Sudah Expired');
        }

        // $no_val = $request->no_validasi;

        // $Exists = DB::table("customer_garanses")->where('no_validasi', $no_val)->exists();
        // if(!$Exists){
        //     return redirect()->route('klaim.create')->with('error', ' Nomor Validasi Tidak terdaftar');
        // }

        $date           = now()->toDateTimeString();
        $jam            =  date('h',strtotime($date));
        $menit          =  date('i',strtotime($date));
        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode       = implode("",$data_kode);
        $kode_tracking = 'TRK_'.$kode.'-'.$jam.'-'.$menit;

        if(! $request->garansi_id){
            $garansi = $request->garansi_id;
        }else{
            $garansi = '0';
        }

        $tgl_pasang = date('Y-m-d',strtotime($request->waktu_pemasangan));



        $klaim_fill = [
            'no_tracking' => $kode_tracking,
            'customer_id' => $request->customer_id,
            'garansi_id' => $garansi,
            'no_nota' => $request->no_nota,
            'no_seri' => $request->no_seri,
            'no_validasi' => $request->no_validasi,
            'tanggal_nota' => $request->tanggal_nota,
            'tanggal_pemasangan' => $tgl_pasang,
            'waktu_pemasangan' => $request->waktu_pemasangan,
            'status' => 'Proses',
        ];


        $klaim_data = CustomerKlaims::create($klaim_fill);

        $thumbnail = null;
        if ($request->hasFile('klaim_photo')) {

            $klaimFoto = count($request->klaim_photo);

            for ($x=0; $x<$klaimFoto; $x++){

                $file = $request->klaim_photo[$x];

                $urutan = $x;

                $thumbnail = (new MediaRepository())->storeByKlaim(
                    $file,
                    'images/klaim/',
                    'klaim images',
                    'image',
                    $urutan
                );


                $server  = request()->server('HTTP_SEC_CH_UA_PLATFORM');
                if($server != '"Windows"'){
                    $img = Image::read(storage_path('app/public/' . $thumbnail->path));

                    $logo = public_path('logo.png');
                    $img->place($logo, 'center', 15, 15);
                    $img->save(storage_path('app/public/' . $thumbnail->path)); //DAN SIMPAN JUGA KE DALAM FOLDER YG SAMA
                }

                $bukti_foto = [
                    'garansi_id'            => '0',
                    'klaim_id'              => $klaim_data->id,
                    'customer_id'           => $klaim_data->customer_id,
                    'foto_id'               => $thumbnail->id,
                    'kode_foto'             => $thumbnail->name,
                    'created_ny'            => $klaim_data->customer_id
                ];
                CustomerBuktiFotos::create($bukti_foto);

            }
        }

        return redirect()->route('klaim.index')->with('success', 'Klaim create successfully');
    }

    public function edit222(Customer $customer)
    {
        return view('customers_klaim.edit', compact('customer'));
    }

    public function edit($id)
    {

        $order      = Order::where('id', $id)->first();

        $garansi    = CustomerGaransis::where('id', $order->garansi_id)->first();

        return view('customers_klaim.edit', compact('order','garansi'));
    }

    public function update(Request $request , $id)
    {

        $websetting = WebSetting::first();

        $masa_berlaku = $websetting->masa_berlaku;

        $tgl_pasang = date('Y-m-d', strtotime($request->waktu_pemasangan));

        $dateExp = strtotime('+'.$masa_berlaku.' days', strtotime($tgl_pasang));
        $dateExps = date('d-m-Y', $dateExp);

        $paymentDate = now();
        $paymentDate = date('Y-m-d', strtotime($paymentDate));
        //echo $paymentDate; // echos today!
        $contractDateBegin = date('Y-m-d', strtotime($tgl_pasang));
        $contractDateEnd = date('Y-m-d', strtotime($dateExps));

        if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                $berlaku_s ='Berlaku';
        }else{
            if($paymentDate <= $contractDateEnd){

                $berlaku_s ='Berlaku';
            }else{
                $berlaku_s ='Expired';
            }
        }

        if($berlaku_s == 'Expired'){
            return redirect()->route('klaim.edit', $id)->with('error', ' Tanggal Pemasangan Sudah Expired');
        }
        // END CEK VALIDASI


        $date           = now()->toDateTimeString();
        $jam            =  date('h',strtotime($date));
        $menit          =  date('i',strtotime($date));
        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode       = implode("",$data_kode);
        $kode_tracking = 'TRK_'.$kode.'-'.$jam.'-'.$menit;

        $order      = Order::where('id', $id)->first();

        $klaim_fill = [
            'no_tracking'           => $kode_tracking,
            'customer_id'           => $order->customer_id,
            'tanggal_nota'          => $order->tanggal_nota,
            'tanggal_pemasangan'    => $tgl_pasang,
            'waktu_pemasangan'      => $request->waktu_pemasangan,
            'status'                => 'Proses',
        ];
        $klaim_data = CustomerKlaims::create($klaim_fill);

        $thumbnail = null;
        if ($request->hasFile('klaim_photo')) {

            $klaimFoto = count($request->klaim_photo);

            for ($x=0; $x<$klaimFoto; $x++){

                $file = $request->klaim_photo[$x];

                $urutan = $x;

                $thumbnail = (new MediaRepository())->storeByKlaim(
                    $file,
                    'images/klaim/',
                    'klaim images',
                    'image',
                    $urutan
                );

                $img = Image::read(storage_path('app/public/' . $thumbnail->path));

                $tanggal        = date('d/m/Y');
                $date           = now()->toDateTimeString();
                $jam            =  date('H',strtotime($date));
                $menit          =  date('i',strtotime($date));
                $text_wtr1 = 'Pukul  '.$jam.':'.$menit.'   Tanggal '.$tanggal;
                $text_wtr2 = 'Tanggal '.$tanggal;


                $logo = public_path('logo.png');
                $img->place($logo, 'center', 15, 15);

                $img->text($text_wtr1, 450, 100, function($font) {
                    $font->file(public_path('rabbit.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    $font->size(24);
                    $font->color('#d71717');
                    $font->align('center');
                    $font->valign('bottom');
                });

                $img->save(storage_path('app/public/' . $thumbnail->path)); //DAN SIMPAN JUGA KE DALAM FOLDER YG SAMA

                $bukti_foto = [
                    'klaim_id'            => $klaim_data->id,
                    'klaim_id'              => '0',
                    'customer_id'           => $klaim_data->customer_id,
                    'foto_id'               => $thumbnail->id,
                    'kode_foto'             => $thumbnail->name,
                    'created_ny'            => $klaim_data->customer_id
                ];
                CustomerBuktiFotos::create($bukti_foto);
            }
        }

        $orderUpdate = array(
            'klaim_id'    => $klaim_data->id,
        );
        Order::where('id', $id)->update($orderUpdate);

        return redirect()->route('klaim.index')->with('success', 'Data successfully send, Admin Sedang Proses !!');
    }

    public function proses_action(Request $request, $id)
    {


        $klaim_data = DB::table('customer_klaims')->where('id', $id)->update(array(
                    'status' => $request->status,
                    'keterangan' => $request->keterangan,
                ));

        return redirect()->route('klaim.index')->with('success', 'Klaim Proses successfully');
    }


    public function disetujui(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update(array(
                'order_status' => 'Disetujui',
            ));

        $order = DB::table('orders')->where('id', $id)->first();

        DB::table('customer_klaims')->where('id', $order->klaim_id)->update(array(
            'status' => 'Disetujui',
        ));

        $kode_coupon = Coupon::where('is_pakai', '0')->first();

        if($kode_coupon){
            DB::table('coupons')->where('id', $kode_coupon->id)->update(array(
                'order_id' => $id,
                'is_pakai' => '1',
            ));
        }


        return redirect()->route('klaim.index')->with('success', 'Proses successfully');
    }

    public function ditolak(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update(array(
                'order_status' => 'Ditolak',
            ));

        $order = DB::table('orders')->where('id', $id)->first();

        DB::table('customer_klaims')->where('id', $order->klaim_id)->update(array(
            'status' => 'Ditolak',
        ));

        return redirect()->route('klaim.index')->with('success', 'Proses successfully');
    }

    public function delete($id)
    {

        if($id){
            $klaim = CustomerKlaims::where('id', $id)->first();

            $bukti = CustomerBuktiFotos::where('klaim_id', $klaim->id)->get();
            if(!empty($bukti)){

                foreach($bukti as $idfoto){
                    $foto = Media::where('id', $idfoto)->first();

                    if(!empty($foto)){
                        Media::where('id', $idfoto)->delete();
                    }

                }

            }

            CustomerBuktiFotos::where('klaim_id', $klaim->id)->delete();
            CustomerKlaims::where('id', $id)->delete();

        }

        return back()->with('success', 'Klaims deleted successfully');
    }

    public function check_validasi(Request $request)
    {

        $customer_id = $request->customer_id;
        $no_val = $request->nomor_val;

        $Exists = DB::table("customer_garanses")
            ->where('no_validasi', $no_val)
            ->where('customer_id', $customer_id)
            ->exists();
        return response()->json(['exists' => $Exists]);
    }


    public function kode_smp($date)
    {

        $jam            =  date('H',strtotime($date));
        $menit          =  date('i',strtotime($date));


        $data_kode  = ['M','E','T','A','L','I','N','D','O','P'];
        shuffle($data_kode);
        $kode        = implode("",$data_kode);

        $data_kode2  = array('M' => '0', 'E'=>'1', 'T' => '2', 'A' =>'3','L' =>'4', 'I' =>'5','N' =>'6','D' =>'7', 'O' =>'8','P' =>'9');

        $jam1 = array_search(substr($jam,0,1 ), $data_kode2);
        $jam2 = array_search(substr($jam,1,1 ), $data_kode2);

        $menit1 = array_search(substr($menit,0,1 ), $data_kode2);
        $menit2 = array_search(substr($menit,1,1 ), $data_kode2);

        $foto_bukti = 'SMP_'.$kode.'_'.$jam1.$jam2.'X'.$menit1.$menit2;


        return $foto_bukti;
    }

}
