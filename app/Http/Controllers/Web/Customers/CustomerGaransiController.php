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


    public function shuffle_me($shuffle_me) { 
        $randomized_keys = array_rand($shuffle_me, count($shuffle_me)); 
        foreach($randomized_keys as $current_key) { 
            $shuffled_me[$current_key] = $shuffle_me[$current_key]; 
        } 
        return $shuffled_me; 
    } 
    

    public function store(Request $request)
    {

        

        $thumbnail = null;
        if ($request->hasFile('garansi_photo')) {

            $garansiFoto = count($request->garansi_photo);

            for ($x=0; $x<$garansiFoto; $x++){

                $file = $request->garansi_photo[$x];

                
                $thumbnail = (new MediaRepository())->storeByGaransi(
                    $file,
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
