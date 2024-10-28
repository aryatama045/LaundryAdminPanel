<?php


namespace App\Repositories;

use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\CustomerGaransiRequest;
use App\Http\Requests\CustomerKlaimRequest;
use App\Models\CustomerBuktiFotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerGaransiRepository extends Repository
{

    public function model()
    {
        return CustomerBuktiFotos::class;
    }

    public function getAllOrFindBySearch()
    {
        $searchKey = \request('search');
        $garansis = $this->model()::query();

        if ($searchKey) {
            $garansis = $garansis->whereHas('user', function ($garansi) use ($searchKey) {
                $garansi->where('first_name', 'like', "%{$searchKey}%")
                    ->orWhere('no_nota', 'like', "%{$searchKey}%")
                    ->orWhere('no_pemasangan', 'like', "%{$searchKey}%");
            });
        }

        return $garansis->latest('id')->get();
    }

    public function storeBuktiFoto(CustomerBuktiFotos $garansi,$thumbnail): CustomerBuktiFotos
    {

        return $this->create([
            'garansi_id'            => $garansi->id,
            'customer_id'           => $garansi->customer_id,
            'foto_id'               => $thumbnail->id,
            'kode_foto'             => $thumbnail->name,
            'created_ny'            => $garansi->customer_id
        ]);

    }


}
