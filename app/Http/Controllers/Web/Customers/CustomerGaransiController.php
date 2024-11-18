<?php

namespace App\Http\Controllers\Web\Customers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MediaRepository;
use App\Repositories\CustomerGaransiRepository;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerGaransis;
use App\Models\CustomerBuktiFotos;
use App\Models\Media;
use App\Events\KlaimMailEvent;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use DB;


class CustomerGaransiController extends Controller
{

    public function index()
    {
        $garansis = (new CustomerGaransiRepository())->getAllOrFindBySearch();

        return view('customers_garansi.index', compact('garansis'));
    }

    public function show(CustomerGaransis $garansi)
    {
        return view('customers_garansi.show', [
            'garansi' => $garansi
        ]);
    }

    public function create()
    {
        $customer = Customer::get();
        return view('customers_garansi.create', compact('customer'));
    }


    public function store(Request $request)
    {


        $validatedData = $request->validate([
                'garansi_photo'=> 'mimes:jpeg,jpg,png,gif|max:5000',
            ],
            [
            'garansi_photo.required'=> 'Bukti foto harus image', // custom message
            ]
        );

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
                    'garansi_id'            => $garansi_data->id,
                    'klaim_id'              => '0',
                    'customer_id'           => $garansi_data->customer_id,
                    'foto_id'               => $thumbnail->id,
                    'kode_foto'             => $thumbnail->name,
                    'created_ny'            => $garansi_data->customer_id
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
        $garansi = CustomerGaransis::where('id', $id)->first();

        return view('customers_garansi.edit', compact('garansi'));
    }

    public function update(Request $request , $id)
    {
        $tgl_pasang = date('Y-m-d',strtotime($request->waktu_pemasangan));
        $dataUpdate= array(
            'tanggal_pemasangan' => $tgl_pasang,
            'waktu_pemasangan' => $request->waktu_pemasangan,
        );
        CustomerGaransis::where('id', $id)->update($dataUpdate);

        return redirect()->route('garansi.index')->with('success', 'Update successfully');
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
}
