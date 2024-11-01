<?php

namespace App\Http\Controllers\Web\Customers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MediaRepository;
use App\Repositories\CustomerKlaimRepository;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerKlaims;
use App\Models\CustomerBuktiFotos;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use DB;


class CustomerKlaimController extends Controller
{

    public function index()
    {
        $klaims = (new CustomerKlaimRepository())->getAllOrFindBySearch();

        return view('customers_klaim.index', compact('klaims'));
    }

    public function show(CustomerKlaims $klaims)
    {
        return view('customers_klaim.show', [
            'klaims' => $klaims
        ]);
    }

    public function create()
    {
        $customer = Customer::get();
        return view('customers_klaim.create', compact('customer'));
    }


    public function store(Request $request)
    {
        

        $klaim_fill = [
            'customer_id' => $request->customer_id,
            'no_nota' => $request->no_nota,
            'tanggal_nota' => $request->tanggal_nota,
            'no_pemasangan' => $request->no_pemasangan,
            'tanggal_pemasangan' => $request->tanggal_pemasangan,
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

                $logo = public_path('logo.png');
                $img->place($logo, 'center', 15, 15);
                $img->save(storage_path('app/public/' . $thumbnail->path)); //DAN SIMPAN JUGA KE DALAM FOLDER YG SAMA


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

    public function delete(Customer $customer)
    {
        $user = $customer->user;

        $customer->devices()->delete();
        $customer->addresses()->delete();

        $customer->delete();

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }

    public function toggleStatus(User $user)
    {
        (new UserRepository())->toggleStatus($user);
        return back()->with('success','Status update successfully');
    }
}
