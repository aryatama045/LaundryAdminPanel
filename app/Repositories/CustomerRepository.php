<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\StripeKey;
use App\Models\User;

class CustomerRepository extends Repository
{
    public function model()
    {
        return Customer::class;
    }

    public function getAllOrFindBySearch()
    {
        $searchKey = \request('search');
        $customers = $this->model()::query();

        if ($searchKey) {
            $customers = $customers->whereHas('user', function ($user) use ($searchKey) {
                $user->where('first_name', 'like', "%{$searchKey}%")
                    ->orWhere('last_name', 'like', "%{$searchKey}%")
                    ->orWhere('email', 'like', "%{$searchKey}%");
            });
        }

        return $customers->latest('id')->get();
    }

    public function storeByUser(User $user): Customer
    {

        return $this->create([
            'user_id' => $user->id,
            'stripe_customer' => ''
        ]);
    }

    public function updateByUser(Customer $customer):Customer
    {
        $user = $customer->user;

        $this->update($customer,[
            'user_id' => $user->id,
            'stripe_customer' => ''
        ]);
        return $customer;
    }
}
