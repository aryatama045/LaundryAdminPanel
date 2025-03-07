<?php

namespace App\Http\Controllers\Web\Customers;


use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MediaRepository;
// use App\Repositories\CustomerGaransiRepository;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\CustomerGaransis;
use App\Models\CustomerBuktiFotos;
use App\Models\Order;
use App\Models\Media;
use App\Events\KlaimMailEvent;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use DB;
use DataTables;


class CustomerGaransiController extends Controller
{


    public function index(Request $request)
    {


        if ($request->ajax()) {
            $roles   = '';
            $user_id = auth()->user();

            if($user_id){
                $roles   = $user_id['roles'][0]->name;
            }

            if($roles == 'root' || $roles == 'admin' ){
                $data = Order::get();
            }else{
                $data = Order::where('customer_id', $user_id->id)->get();
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    $img = ' -- ';
                    $bukti     = '';

                    if($row->garansi_id){
                        $bukti      = CustomerBuktiFotos::where('garansi_id', $row->garansi_id)->first();
                        $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();
                        if($garansi){
                            $waktu      = $this->kode_smp($garansi->waktu_pemasangan);
                        }else{
                            $waktu      = '';
                        }
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
                        center center;"></span></a><br>

                        <br><small>'. $get_media->src .'</small>

                        ';
                    }

                    return $img;
                })
                ->addColumn('created_at', function ($row) {
                    $created_at = $row->created_at == '' ? '-' : date('d-m-Y', strtotime($row->created_at));
                    return $created_at;
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
                ->addColumn('waktu', function ($row) {
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                    if($garansi){
                        $result =  date('H:i',strtotime($garansi->waktu_pemasangan));
                    }else{
                        $result = '-';
                    }

                    return $result;
                })
                ->addColumn('tanggal', function ($row) {
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();
                    if($garansi){
                        $result =  date('d-m-Y', strtotime($garansi->tanggal_pemasangan));
                    }else{
                        $result = '-';
                    }
                    return $result;
                })

                ->addColumn('terproteksi', function ($row) {
                    $result = '-';
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                    if($garansi){
                        if($garansi->status  == 'Disetujui'){

                            $websetting = WebSetting::first();

                            $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                            $masa_berlaku = $websetting->masa_berlaku;

                            $dateExp = strtotime('+'.$masa_berlaku.' days', strtotime($garansi->waktu_pemasangan));
                            $dateExps = date('d-m-Y H:i:s', $dateExp);

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
                    }
                    return $result;

                })
                ->addColumn('tambah_proteksi', function ($row) {

                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                    $tambah_proteksi = '';
                    if($row->qty > 0){



                        if($garansi){
                            if($garansi->status == 'Diproses' || $garansi->status == 'Disetujui'){
                                $tambah_proteksi .= '<span class="text-grey text-center"><b>Sudah Mendapat Proteksi</b></span>';
                            }else if($garansi->status == 'Ditolak'){
                                $tambah_proteksi .= '<span class="text-danger"><b>Ditolak</b></span>';
                            }else{
                                $tambah_proteksi .= '';
                            }
                        }else{
                            if($row->barang_garansi == 'YA'){
                                $tambah_proteksi .= '<span class="text-success text-center"><a href="'. route('garansi.edit',$row->id) .'"><b>Klik Disini Tambah Proteksi</b></a></span>';
                            }else{
                                $tambah_proteksi .= '<span class="text-grey text-center"><b>Tidak Ada Garansi</b></span>';
                            }

                        }
                    }else{

                        $tambah_proteksi .= 'Tidak Ada Qty';

                    }

                    return $tambah_proteksi;
                })

                ->addColumn('status', function ($row) use ($request) {
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();
                    if($garansi ){
                        $result = '<span class="text-success"><i class="fa fa-check-circle"></i></span>';
                    }else{
                        $result = '';
                    }

                    return $result;
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $roles   = '';
                    $user_id = auth()->user();
                    if($user_id){
                        $roles   = $user_id['roles'][0]->name;
                    }

                    // $kode_coupon = Coupon::where('order_id', $row->id)->first();
                    $garansi    = CustomerGaransis::where('id', $row->garansi_id)->first();

                    if($roles=='root' || $roles=='admin'){

                        if($garansi){
                            if($garansi->status == 'Diproses'){
                                $button .= '
                                    <a href="'.route('garansi.disetujui', $row->id) .'"
                                        class="btn btn-primary py-1 px-2">
                                        Disetujui
                                    </a>';

                                $bukti     = '';

                                if($row->garansi_id){
                                    $bukti      = CustomerBuktiFotos::where('garansi_id', $row->garansi_id)
                                                    ->where('type', 'video')->first();

                                    if($bukti){
                                        $get_media = DB::table('media')->where('id', $bukti->foto_id)->first();

                                        $button .= '</br> </br>
                                        <a href="'. Storage::url($get_media->path) .'"
                                            target="_blank"  class="btn btn-primary py-1 px-2">
                                            Download Video
                                        </a>';
                                    }

                                }

                                $button .= ' </br> </br>
                                    <a href="'.route('garansi.ditolak', $row->id) .'"
                                        class="btn btn-danger py-1 px-2">
                                        Ditolak
                                    </a>';
                            }

                            if($garansi->status == 'Disetujui'){
                                $button .= '<span class="text-success"><b>Disetujui</b></span>';
                            }else if($garansi->status == 'Ditolak'){
                                $button .= '<span class="text-danger"><b>Ditolak</b></span>';
                            }else{
                                $button .= '<span class=""> - </span>';
                            }
                        }else{
                            $button .= '<span class=""> - </span>';
                        }

                        // if($row->order_status == 'Disetujui'){
                        //     $button .= ($kode_coupon)?$kode_coupon->code:'Tidak ada kode';
                        // }
                    }else{
                        if($garansi){
                            if($garansi->status == 'Disetujui'){
                                $button .= '<span class="text-success"><b>Disetujui</b></span>';
                            }else if($garansi->status == 'Diproses'){
                                $button .= '<span class="text-info"><b>Diproses</b></span>';
                            }else if($garansi->status == 'Ditolak'){
                                $button .= '<span class="text-danger"><b>Ditolak</b></span>';
                            }else{
                                $button .= '<span class=""> - </span>';
                            }
                        }else{
                            $button .= '<span class=""> - </span>';
                        }

                    }

                    return $button;
                })
                ->rawColumns(['action','created_at','tanggal_nota','nomor_nota','nama_customer','nama_barang','qty','terproteksi','waktu','tanggal','tambah_proteksi','img','status'])
                ->make(true);
        }

        // $garansis = (new CustomerGaransiRepository())->getAllOrFindBySearch();

        return view('customers_garansi.index');
    }

    // <tbody>
        //     @if(!empty($garansis))
        //     @foreach ($garansis as $garansi)
        //         <tr>
        //             @role('root')
        //             <td>{{ $garansi->user->name }}</td>
        //             @endrole
        //             <td>
        //                 {{ $garansi->no_nota }} <br>
        //                 <small> Tgl nota : {{ date('d-m-Y', strtotime($garansi->tanggal_nota)) }} </small>
        //             </td>
        //             <td>
        //                 Waktu : {{ date('H:i:s',strtotime($garansi->waktu_pemasangan)) }} <br>
        //                 <small> Tgl pemasangan : {{ date('d-m-Y', strtotime($garansi->tanggal_pemasangan)) }} </small>
        //             </td>
        //             <td>
        //                 @php
        //                     $websetting = App\Models\WebSetting::first();

        //                     $masa_berlaku = $websetting->masa_berlaku;

        //                     $dateExp = strtotime('+'.$masa_berlaku.' days', strtotime($garansi->tanggal_pemasangan));
        //                     $dateExps = date('d-m-Y', $dateExp);


        //                     $paymentDate = now();
        //                     $paymentDate = date('Y-m-d', strtotime($paymentDate));
        //                     //echo $paymentDate; // echos today!
        //                     $contractDateBegin = date('Y-m-d', strtotime($garansi->tanggal_pemasangan));
        //                     $contractDateEnd = date('Y-m-d', strtotime($dateExps));

        //                     if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
        //                             $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
        //                     }else{
        //                         if($paymentDate <= $contractDateEnd){

        //                             $berlaku_s ='<span class="badge badge-success"> Berlaku : '.now()->diffInDays($dateExps).' Hari </span> <br>';
        //                         }else{
        //                             $berlaku_s ='<span class="badge badge-danger"> Berlaku : Expired </span> <br>';
        //                         }

        //                     }
        //                 @endphp

        //                 {!! $berlaku_s !!}
        //                 <small> Sampai : {{ $dateExps }} </small>

        //             </td>

        //             <td>
        //                 <a href="{{ route('garansi.show', $garansi->id) }}"
        //                     class="btn btn-primary py-1 px-2">
        //                     <i class="fa fa-eye"></i>
        //                 </a>

        //                 @role('root')
        //                     <a href="{{ route('garansi.edit', $garansi->id) }}"
        //                         class="btn btn-info py-1 px-2">
        //                         <i class="fa fa-edit"></i>
        //                     </a>

        //                     <a href="{{ route('garansi.delete', $garansi->id) }}"
        //                         class="btn btn-danger py-1 px-2 delete-confirm" >
        //                         <i class="fa fa-trash"></i>
        //                     </a>
        //                 @endrole
        //             </td>

        //         </tr>
        //     @endforeach
        //     @endif
    // </tbody>

    public function getDataGaransi(Request $request)
    {
        $roles   = '';
        $user_id = auth()->user();

        // dd($user_id->id);

        if($user_id){
            $roles   = $user_id['roles'][0]->name;
        }

        if ($request->ajax()) {

            dd('oke');
            if($roles == 'root' ){
                $data = Order::get();
            }else{
                $data = Order::where('customer_id', $user_id->id)->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    $array = array(
                        "barang_gambar" => $row->barang_gambar,
                    );
                    if ($row->barang_gambar == "image.png") {
                        $img = '<a data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Gmodaldemo8" onclick=gambar(' . json_encode($array) . ')><span class="avatar avatar-lg cover-image" style="background: url(&quot;' . url('/assets/default/barang') . '/' . $row->barang_gambar . '&quot;) center center;"></span></a>';
                    } else {
                        $img = '<a data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Gmodaldemo8" onclick=gambar(' . json_encode($array) . ')><span class="avatar avatar-lg cover-image" style="background: url(&quot;' . url('/uploads/image/' . $row->barang_gambar) . '&quot;) center center;"></span></a>';
                    }

                    return $img;
                })
                ->addColumn('jenisbarang', function ($row) {
                    $jenisbarang = $row->jenisbarang_id == '' ? '-' : $row->jenisbarang_nama;

                    return $jenisbarang;
                })
                ->addColumn('kategori', function ($row) {
                    $kategori = $row->kategori_id == '' ? '-' : $row->kategori_nama;

                    return $kategori;
                })
                ->addColumn('satuan', function ($row) {
                    $satuan = $row->satuan_id == '' ? '-' : $row->satuan_nama;

                    return $satuan;
                })
                ->addColumn('merk', function ($row) {
                    $merk = $row->merk_id == '' ? '-' : $row->merk_nama;

                    return $merk;
                })
                ->addColumn('make_by', function ($row) {
                    $make_by = $row->make_by == '' ? '-' : $row->make_by;

                    return $make_by;
                })
                ->addColumn('currency', function ($row) {
                    $currency = $row->barang_harga == '' ? '-' : 'Rp ' . number_format($row->barang_harga, 0);

                    return $currency;
                })
                ->addColumn('totalstok', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_barangmasuk.supplier_id')->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_supplier', 'tbl_supplier.supplier_id', '=', 'tbl_barangmasuk.supplier_id')->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangmasuk.barang_kode', '=', $row->barang_kode)->sum('tbl_barangmasuk.bm_jumlah');
                    }


                    if ($request->tglawal) {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    } else {
                        $jmlkeluar = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')->where('tbl_barangkeluar.barang_kode', '=', $row->barang_kode)->sum('tbl_barangkeluar.bk_jumlah');
                    }

                    $totalstok = $row->barang_stok + ($jmlmasuk - $jmlkeluar);
                    if($totalstok == 0){
                        $result = '<span class="">'.$totalstok.'</span>';
                    }else if($totalstok > 0){
                        $result = '<span class="text-success">'.$totalstok.'</span>';
                    }else{
                        $result = '<span class="text-danger">'.$totalstok.'</span>';
                    }

                    return $result;
                })
                ->addColumn('action', function ($row) {
                    $array = array(
                        "barang_id" => $row->barang_id,
                        "jenisbarang_id" => $row->jenisbarang_id,
                        "satuan_id" => $row->satuan_id,
                        "merk_id" => $row->merk_id,
                        "barang_id" => $row->barang_id,
                        "barang_kode" => $row->barang_kode,
                        "barang_nama" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->barang_nama)),
                        "barang_harga" => $row->barang_harga,
                        "barang_stok" => $row->barang_stok,
                        "barang_gambar" => $row->barang_gambar,
                    );
                    $button = '';
                    $button .= '
                        <a class="dropdown-item btn modal-effect text-primary btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" data-bs-toggle="tooltip" data-bs-original-title="Edit" onclick=update(' . json_encode($array) . ')><span class="fe fe-edit text-success fs-14"></span> Edit</a>
                    ';

                    $button .= '-';


                    return $button;
                })
                ->rawColumns(['checkbox','action', 'img', 'jenisbarang', 'satuan','kategori', 'merk','currency', 'totalstok', 'make_by'])->make(true);
        }
    }

    public function proses_action(Request $request, $id)
    {


        DB::table('orders')->where('id', $id)->update(array(
                    'order_status' => $request->status,
                ));

        return redirect()->route('garansi.index')->with('success', 'Proses successfully');
    }

    public function disetujui(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update(array(
                'order_status' => 'Disetujui',
            ));

        $order = DB::table('orders')->where('id', $id)->first();

        DB::table('customer_garanses')->where('id', $order->garansi_id)->update(array(
            'status' => 'Disetujui',
        ));
        // $kode_coupon = Coupon::where('is_pakai', '0')->first();
        // DB::table('coupons')->where('id', $kode_coupon->id)->update(array(
        //     'order_id' => $id,
        //     'is_pakai' => '1',
        // ));

        return redirect()->route('garansi.index')->with('success', 'Proses successfully');
    }

    public function ditolak(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update(array(
                'order_status' => 'Ditolak',
            ));

        $order = DB::table('orders')->where('id', $id)->first();

        DB::table('customer_garanses')->where('id', $order->garansi_id)->update(array(
            'status' => 'Ditolak',
        ));

        return redirect()->route('garansi.index')->with('success', 'Proses successfully');
    }

    public function show($id)
    {
        $order      = Order::where('id', $id)->first();

        $garansi    = CustomerGaransis::where('id', $order->garansi_id)->first();

        return view('customers_garansi.show', compact('order','garansi'));

        // return view('customers_garansi.show', [
        //     'garansi' => $garansi
        // ]);
    }

    public function create()
    {
        $customer = Customer::get();
        return view('customers_garansi.create', compact('customer'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'garansi_photo' => ['required', 'array'],
            'garansi_photo.*' => ['required', 'mimes:jpg,jpeg,png,webp'],
        ]);


        $tgl_pasang = date('Y-m-d',strtotime($request->waktu_pemasangan));

        $garansi_fill = [
            'customer_id' => $request->customer_id,
            'no_seri' => $request->no_seri,
            'no_validasi' => $request->no_validasi,
            'no_nota' => $request->no_nota,
            'tanggal_nota' => $request->tanggal_nota,
            'tanggal_pemasangan' => $tgl_pasang,
            'waktu_pemasangan' => $request->waktu_pemasangan,
        ];

        // 'no_pemasangan' => $request->no_pemasangan,
        //  'tanggal_pemasangan' => $request->tanggal_pemasangan,

        $garansi_data = CustomerGaransis::create($garansi_fill);

        $thumbnail = null;
        if ($request->hasFile('garansi_photo')) {

            $garansiFoto = count($request->garansi_photo);

            for ($x=0; $x<$garansiFoto; $x++){

                $file = $request->garansi_photo[$x];

                $urutan = $x;

                $thumbnail = (new MediaRepository())->storeByGaransi(
                    $file,
                    'images/garansi/',
                    'garansi images',
                    'image',
                    $urutan
                );


                // $img = Image::read(storage_path('app/public/' . $thumbnail->path));

                // $tanggal        = date('d/m/Y');
                // $date           = now()->toDateTimeString();
                // $jam            =  date('H',strtotime($date));
                // $menit          =  date('i',strtotime($date));
                // $text_wtr1 = 'Pukul  '.$jam.':'.$menit.'   Tanggal '.$tanggal;
                // $text_wtr2 = 'Tanggal '.$tanggal;


                // $logo = public_path('logo.png');
                // $img->place($logo, 'center', 15, 15);

                // $img->text($text_wtr1, 450, 100, function($font) {
                //     $font->file(public_path('rabbit.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                //     $font->size(24);
                //     $font->color('#d71717');
                //     $font->align('center');
                //     $font->valign('bottom');
                // });

                // $img->save(storage_path('app/public/' . $thumbnail->path)); //DAN SIMPAN JUGA KE DALAM FOLDER YG SAMA

                $bukti_foto = [
                    'garansi_id'            => $garansi_data->id,
                    'klaim_id'              => '0',
                    'customer_id'           => $garansi_data->customer_id,
                    'foto_id'               => $thumbnail->id,
                    'kode_foto'             => $thumbnail->name,
                    'created_by'            => $garansi_data->customer_id
                ];
                CustomerBuktiFotos::create($bukti_foto);

            }
        }

        // $message  = 'New klaim add from ' . $garansi_data->customer->name;
        // KlaimNotificationEvent::dispatch($message);

        // $notificationKlaim = NotificationManage::where('name', 'new_order')->first();

        // if ($notificationKlaim->is_active) {
        //     $keys = $garansi_data->customer->devices->pluck('key')->toArray();

        //     $message = $notificationKlaim->message;

        //     (new NotificationServices($message, $keys, 'New Klaim'));
        // }

        // KlaimMailEvent::dispatch($garansi_data);

        return redirect()->route('garansi.index')->with('success', 'Garansi create successfully');
    }

    public function edit($id)
    {

        $order      = Order::where('id', $id)->first();

        $garansi    = CustomerGaransis::where('id', $order->garansi_id)->first();

        return view('customers_garansi.edit', compact('order','garansi'));
    }

    public function update(Request $request , $id)
    {
        // $this->validate($request, [
        //     'garansi_photo' => ['required', 'array'],
        //     'garansi_photo.*' => ['required', 'mimes:jpg,jpeg,png,webp'],
        // ]);

        $tgl_pasang = date('Y-m-d',strtotime($request->waktu_pemasangan));

        $garansiFoto = count($request->garansi_photo);

        $dataOrder = Order::where('id', $id)->first();

        $garansi_fill = [
            'customer_id'           => $dataOrder->customer_id,
            'no_nota'               => $dataOrder->nomor_nota,
            'tanggal_nota'          => $dataOrder->tanggal_nota,
            'tanggal_pemasangan'    => $tgl_pasang,
            'waktu_pemasangan'      => $request->waktu_pemasangan,
        ];
        $garansi_data = CustomerGaransis::create($garansi_fill);

        $thumbnail = null;
        if ($request->hasFile('garansi_photo')) {

            $garansiFoto = count($request->garansi_photo);

            for ($x=0; $x<$garansiFoto; $x++){

                $file = $request->garansi_photo[$x];

                $urutan = $x;

                $thumbnail = (new MediaRepository())->storeByGaransi(
                    $file,
                    'images/garansi/',
                    'garansi images',
                    'image',
                    $urutan
                );

                // $img = Image::read(storage_path('app/public/' . $thumbnail->path));

                    // $tanggal        = date('d/m/Y');
                    // $date           = now()->toDateTimeString();
                    // $jam            =  date('H',strtotime($date));
                    // $menit          =  date('i',strtotime($date));
                    // $text_wtr1 = 'Pukul  '.$jam.':'.$menit.'   Tanggal '.$tanggal;
                    // $text_wtr2 = 'Tanggal '.$tanggal;


                    // $logo = public_path('logo.png');
                    // $img->place($logo, 'center', 15, 15);

                    // $img->text($text_wtr1, 450, 100, function($font) {
                    //     $font->file(public_path('rabbit.ttf'));   //LOAD FONT-NYA JIKA ADA, SILAHKAN DOWNLOAD SENDIRI
                    //     $font->size(24);
                    //     $font->color('#d71717');
                    //     $font->align('center');
                    //     $font->valign('bottom');
                    // });

                // $img->save(storage_path('app/public/' . $thumbnail->path)); //DAN SIMPAN JUGA KE DALAM FOLDER YG SAMA

                $bukti_foto = [
                    'garansi_id'            => $garansi_data->id,
                    'klaim_id'              => '0',
                    'customer_id'           => $garansi_data->customer_id,
                    'foto_id'               => $thumbnail->id,
                    'kode_foto'             => $thumbnail->name,
                    'created_by'            => $garansi_data->customer_id
                ];
                CustomerBuktiFotos::create($bukti_foto);
            }
        }


        $file_video = $request->garansi_video;

        $thumbnail_video = null;
        if ($file_video) {
            $file_video = $request->garansi_video;

            $thumbnail_video = (new MediaRepository())->updateByGaransiVideo(
                $file_video,
                'images/garansi/',
                'garansi images'
            );

            $bukti_video = [
                'garansi_id'            => $garansi_data->id,
                'klaim_id'              => '0',
                'customer_id'           => $garansi_data->customer_id,
                'foto_id'               => $thumbnail_video->id,
                'kode_foto'             => $thumbnail_video->name,
                'type'                  => 'video',
                'created_by'            => $garansi_data->customer_id
            ];
            CustomerBuktiFotos::create($bukti_video);
        }

        $orderUpdate = array(
            'order_status'  => 'Diproses',
            'garansi_id'    => $garansi_data->id,
        );
        Order::where('id', $id)->update($orderUpdate);

        return redirect()->route('garansi.index')->with('success', 'Data successfully send, Admin Sedang Proses !!');
    }

    public function delete($id)
    {

        if($id){
            $garansi = CustomerGaransis::where('id', $id)->first();

            $bukti = CustomerBuktiFotos::where('garansi_id', $garansi->id)->get();
            if(!empty($bukti)){

                foreach($bukti as $idfoto){
                    $foto = Media::where('id', $idfoto)->delete();
                }

            }

            CustomerBuktiFotos::where('garansi_id', $garansi->id)->delete();
            CustomerGaransis::where('id', $id)->delete();

        }

        return back()->with('success', 'Garansi deleted successfully');
    }

    public function toggleStatus(User $user)
    {
        (new UserRepository())->toggleStatus($user);
        return back()->with('success','Status update successfully');
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
