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

        $garansi_fill = [
            'customer_id' => $request->customer_id,
            'no_nota' => $request->no_nota,
            'tanggal_nota' => $request->tanggal_nota,
            'no_pemasangan' => $request->no_pemasangan,
            'tanggal_pemasangan' => $request->tanggal_pemasangan,
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


                $img = Image::read(storage_path('app/public/' . $thumbnail->path));

                $logo = public_path('logo.png');
                $img->place($logo, 'center', 15, 15);
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

        return redirect()->route('garansi.index')->with('success', 'Garansi create successfully');
    }

    public function edit(Customer $customer)
    {
        return view('customers_garansi.edit', compact('customer'));
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

    public function delete($id)
    {

        if($id){
            $garansi = CustomerGaransis::where('id', $id)->first();

            $bukti = CustomerBuktiFotos::where('garansi_id', $garansi->id)->get();
            if(!empty($bukti)){
                $bukti->each->delete();
                foreach($bukti as $idfoto){
                    $foto = Media::where('id', $idfoto)->each->delete();
                }
                $bukti->each->delete();
            }

            $garansi->each->delete();

        }

        return back()->with('success', 'User deleted successfully');
    }

    public function toggleStatus(User $user)
    {
        (new UserRepository())->toggleStatus($user);
        return back()->with('success','Status update successfully');
    }
}
