<?php


namespace App\Repositories;

use App\Http\Requests\AddressRequest;
use App\Models\Address;

class AddressRepository extends Repository
{
    public function model()
    {
        return Address::class;
    }

    public function getAll()
    {
        $customer = auth()->user()->customer;
        return $this->model()::where('customer_id', $customer->id)->get();
    }

    public function storeByRequest(AddressRequest $request): Address
    {
        return $this->model()::create([
            'customer_id' => auth()->user()->customer->id,
            'address_name' => $request->address_name,
            'road_no' => $request->road_no,
            'house_no' => $request->house_no,
            'house_name' => $request->house_name,
            'flat_no' => $request->flat_no,
            'block' => $request->block,
            'area' => $request->area,
            'sub_district_id' => $request->sub_district_id,
            'district_id' => $request->district_id,
            'address_line' => $request->address_line,
            'address_line2' => $request->address_line2,
            'delivery_note' => $request->delivery_note,
            'post_code' => $request->post_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    }

    public function updateByRequest(Address $address, AddressRequest $request): Address
    {
        $address->update([
            'customer_id' => auth()->user()->customer->id,
            'address_name' => $request->address_name,
            'road_no' => $request->road_no,
            'house_no' => $request->house_no,
            'house_name' => $request->house_name,
            'flat_no' => $request->flat_no,
            'block' => $request->block,
            'area' => $request->area,
            'sub_district_id' => $request->sub_district_id,
            'district_id' => $request->district_id,
            'address_line' => $request->address_line,
            'address_line2' => $request->address_line2,
            'delivery_note' => $request->delivery_note,
            'post_code' => $request->post_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        return $address;
    }
}
