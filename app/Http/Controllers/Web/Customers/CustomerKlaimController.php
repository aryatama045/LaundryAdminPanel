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


class CustomerKlaimController extends Controller
{

    public function index()
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


}
