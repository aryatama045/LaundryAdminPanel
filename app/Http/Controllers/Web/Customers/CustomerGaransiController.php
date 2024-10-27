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


class CustomerGaransiController extends Controller
{
    private $path = 'images/customers/';

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


    // Function getNewFileName 
    public function getNewFileName($filename, $extension, $path)
    {
        $date   = now()->toDateTimeString();
        $jam    =  date('h',strtotime($date));
        $menit  =  date('i',strtotime($date));
        $data_kode = ['M','E','T','A','L','I','N','D','O','P'];
        $rk = array_rand($data_kode, 8);
        $kode = $data_kode[$rk];
        $kode_name = 'SMP_'.$kode.'_'.$jam.'X'.$menit.'-'.$x;

        $i = 1;
        $new_filename = $filename . '.' . $extension;
        while (File::exists($path . $new_filename))
            $new_filename = $kode_name . '_' . $i++ . '.' . $extension;
        return $new_filename;

    }

    public function store(Request $request)
    {

        

        $thumbnail = null;
        if ($request->hasFile('garansi_photo')) {

            $garansiFoto = count($request->garansi_photo);

            for ($x=0; $x<$garansiFoto; $x++){

                $file = $request->garansi_photo;

                $originalName = $file->getClientOriginalName();
                $filename = str_slug(pathinfo($originalName, PATHINFO_FILENAME), "-");
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                
                //Call getNewFileName function 
                $finalFullName = $this->getNewFileName($filename, $extension, $path);
                

                
                
                dd($file_name);

                $thumbnail = (new MediaRepository())->storeByGaransi(
                    $request->garansi_photo,
                    $this->path,
                    'garansi images',
                    'image'
                );
            }
        }

        dd('salah');


        $user = (new UserRepository())->registerUser($request);
        (new CustomerRepository())->storeByUser($user);
        $user->assignRole('customer');
        $user->update([
            'mobile_verified_at' => now()
        ]);

        
        return redirect()->route('customer_garansi.index')->with('success', 'Garansi create successfully');
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
