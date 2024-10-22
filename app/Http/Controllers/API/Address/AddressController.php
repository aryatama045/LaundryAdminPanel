<?php

namespace App\Http\Controllers\API\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Repositories\AddressRepository;

class AddressController extends Controller
{
    private $addressRepo;
    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepo = $addressRepository;
    }

    public function index()
    {
        return $this->json('address list', [
            'addresses' => AddressResource::collection($this->addressRepo->getAll())
        ]);
    }

    public function store(AddressRequest $request)
    {
        $addresses = auth()->user()->customer->addresses;
        if(!$addresses->isEmpty() && $addresses->count() >= 3){
            return $this->json('sorry, you can\'t add more address');
        }
        $this->addressRepo->storeByRequest($request);

        return $this->json('Address is added successfully', [
            'addresses' => AddressResource::collection($this->addressRepo->getAll())
        ]);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $this->addressRepo->updateByRequest($address, $request);

        return $this->json('Address is updated successfully', [
            'addresses' => AddressResource::collection($this->addressRepo->getAll())
        ]);
    }

    public function delete(Address $address)
    {
        $address->delete();
        return $this->json('Address delete successfully',[
            'addresses' => AddressResource::collection($this->addressRepo->getAll())
        ]);
    }
}
