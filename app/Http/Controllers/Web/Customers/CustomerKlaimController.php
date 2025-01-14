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
                $data = Order::where('customer_id', $user_id->id)->Where('klaim_id','!=','')->get();
            }

            return DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    $img = ' -- ';

                    $bukti = CustomerBuktiFotos::where('garansi_id', $row->garansi_id)->first();

                    if($bukti){
                        $get_media = DB::table('media')->where('id', $bukti->foto_id)->first();

                        $array = array(
                            "barang_gambar" => $get_media->path,
                        );

                        $img = '<a data-effect="effect-super-scaled" data-toggle="modal" href="#Gmodaldemo8"
                        onclick=gambar(' . json_encode($array) . ')>
                        <span class="avatar avatar-lg cover-image text-center"
                        style="background: url(&quot;' . Storage::url($get_media->path) . '&quot;)
                        center center;"></span></a>';
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
                    if($row->order_status == 'Disetujui'){

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


                    }else if($row->order_status == 'Diproses'){
                        $result = '<span class="text-grey"><b>Diproses</b></span>';
                    }else if($row->order_status == 'Ditolak'){
                        $result = '<span class="text-danger"><b>Ditolak</b></span>';
                    }else{
                        $result = '<span class=""> - </span>';
                    }
                    return $result;

                })

                ->addColumn('waktu_rusak', function ($row) {
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();
                    $waktu = $klaim->waktu_pemasangan;
                    if($waktu){
                        $result =  date('H:i:s',strtotime($klaim->waktu_pemasangan));
                    }else{
                        $result = '-';
                    }

                    return $result;
                })
                ->addColumn('tanggal_rusak', function ($row) {
                    $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();
                    $tanggal = $klaim->tanggal_pemasangan;
                    if($tanggal){
                        $result =  date('d-m-Y', strtotime($klaim->tanggal_pemasangan));
                    }else{
                        $result = '-';
                    }
                    return $result;
                })

                ->addColumn('status', function ($row) use ($request) {

                    $result = '<span class="text-success"><i class="fa fa-check-circle"></i></span>';
                    return $result;
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
                            $button .= '</br><span class="text-success"><b>Disetujui</b></span>';

                            if($row->order_status == 'Disetujui'){
                                $button .= ($kode_coupon)?'<br> Kode : '.$kode_coupon->code:'Tidak ada kode';
                            }

                        }else if($klaim->status == 'Ditolak'){
                            $button .= '</br><span class="text-danger"><b>Ditolak</b></span>';
                        }else{
                            $button .= '</br><span class=""> - </span>';
                        }
                    }else{
                        $klaim    = CustomerKlaims::where('id', $row->klaim_id)->first();
                        if($klaim->status == 'Disetujui'){
                            $button .= '</br><span class="text-success"><b>Disetujui</b></span>';
                        }else if($klaim->status == 'Proses'){
                            $button .= '</br><span class="text-grey"><b>Diproses</b></span>';
                        }else if($klaim->status == 'Ditolak'){
                            $button .= '</br><span class="text-danger"><b>Ditolak</b></span>';
                        }else{
                            $button .= '</br><span class=""> - </span>';
                        }
                    }


                    return $button;
                })
                ->rawColumns(['action','tanggal_nota','nomor_nota','nama_customer','nama_barang','qty','terproteksi','tanggal_rusak','waktu_rusak','tambah_proteksi','img','status'])
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

        $dateExp = strtotime('+90 days', strtotime($tgl_pasang));
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

    public function edit(Customer $customer)
    {
        return view('customers_klaim.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'mobile' => "required|numeric|unique:users,mobile," . $customer->user->id,
            'email' => "required|unique:users,email," . $customer->user->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
        (new UserRepository())->updateProfileByRequest($request, $customer->user);

        return redirect()->route('customer.index')->with('success', 'Customer Update successfully');
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

        $kode_coupon = Coupon::where('is_pakai', '0')->first();
        DB::table('coupons')->where('id', $kode_coupon->id)->update(array(
            'order_id' => $id,
            'is_pakai' => '1',
        ));

        return redirect()->route('klaim.index')->with('success', 'Proses successfully');
    }

    public function ditolak(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update(array(
                'order_status' => 'Ditolak',
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


}
