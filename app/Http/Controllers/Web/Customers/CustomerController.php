<?php

namespace App\Http\Controllers\Web\Customers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = (new CustomerRepository())->getAllOrFindBySearch();
        return view('customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer' => $customer
        ]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(RegistrationRequest $request)
    {
        $user = (new UserRepository())->registerUser($request);
        (new CustomerRepository())->storeByUser($user);

        $user->update([
            'mobile_verified_at' => now()
        ]);
        $user->assignRole('Customer');
        $user->givePermissionTo('root');
        $user->givePermissionTo('customer.index');
        $user->givePermissionTo('customer.show');
        $user->givePermissionTo('customer.edit');
        $user->givePermissionTo('customer.update');
        $user->givePermissionTo('customer.create');
        $user->givePermissionTo('customer.store');

        $user->givePermissionTo('garansi.index');
        $user->givePermissionTo('garansi.show');
        $user->givePermissionTo('garansi.edit');
        $user->givePermissionTo('garansi.update');
        $user->givePermissionTo('garansi.create');
        $user->givePermissionTo('garansi.store');

        $user->givePermissionTo('klaim.index');
        $user->givePermissionTo('klaim.show');
        $user->givePermissionTo('klaim.edit');
        $user->givePermissionTo('klaim.update');
        $user->givePermissionTo('klaim.create');
        $user->givePermissionTo('klaim.store');
        $user->givePermissionTo('klaim.check_validasi');

        return redirect()->route('customer.index')->with('success', 'Customer create successfully');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'company' => 'nullable',
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
        $orders = $customer->orders;

        foreach ($orders as $order) {
            $order->payment->delete();
            $order->products()->detach();
            $order->rating->delete();
            $order->additionals()->detach();
            $order->delete();
        }
        $customer->devices()->delete();
        $customer->addresses()->delete();

        $customer->cards()->delete();

        $customer->notifications()->delete();

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
