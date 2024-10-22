<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Repositories\UserRepository;

class CustomerController extends Controller
{
    public function show()
    {
        $customer = auth()->user()->customer;
        return $this->json('customer details', [
            'customer' => (new CustomerResource($customer))
        ]);
    }

    public function toggleStatus(User $user)
    {
        (new UserRepository())->toggleStatus($user);
        return $this->json('Deactive Successfully');
    }
}
