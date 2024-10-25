<?php


namespace App\Repositories;

use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\CustomerGaransiRequest;
use App\Models\CustomerGaransis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerGaransiRepository extends Repository
{
    private $path = 'images/garansi/';
    public function model()
    {
        return CustomerGaransis::class;
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

    public function storeByUser(CustomerGaransis $garansi): CustomerGaransis
    {

        return $this->create([
            'user_id' => $garansi->id,
            'stripe_customer' => ''
        ]);
    }

    public function registerGaransi(Request $request)
    {
        $thumbnail = null;
        if ($request->hasFile('garansi_photo')) {
            $thumbnail = (new MediaRepository())->storeByRequest(
                $request->garansi_photo,
                $this->path,
                'garansi images',
                'image'
            );
        }

        $garansi = $this->create([
            'customer_id'           => $customer->customer_id,
            'no_nota'               => $customer->no_nota,
            'tanggal_nota'          => $customer->tanggal_nota,
            'no_pemasangan'         => $customer->no_pemasangan,
            'tanggal_pemasangan'    => $customer->tanggal_pemasangan,

        ]);

        return $garansi;
    }





    public function findActiveByContact($contact)
    {
        return $this->model()::where('mobile', $contact)
            ->orWhere('email', $contact)
            ->isActive()
            ->first();
    }

    public function findByContact($contact)
    {
        return $this->model()::where('mobile', $contact)
            ->orWhere('email', $contact)
            ->first();
    }

    public function findById($id)
    {
        return $this->model()::find($id);
    }

    public function updateByRequest(GaransiRequest $request, $garansi): Garansi
    {
        $thumbnail = $this->profileImageUpdate($request, $garansi);

        $garansi->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            'mobile' => $request->mobile,
            "gender" => $request->gender,
            "alternative_phone" => $request->alternative_phone,
            'garansi_photo_id' => $thumbnail ? $thumbnail->id : null,
            "driving_lience" =>$request->driving_lience,
            "date_of_birth" =>$request->date_of_birth,
        ]);

        return $garansi;
    }
    public function updateProfilePhotoByRequest(ProfilePhotoRequest $request, $garansi): Garansi
    {
        $thumbnail = (new MediaRepository())->storeByRequest(
            $request->profile_photo,
            $this->path,
            'customer images',
            'image'
        );

        $garansi->update([
            'garansi_photo_id' => $thumbnail->id
        ]);

        return $garansi;
    }

    public function updateProfileByRequest($request, $garansi)
    {
        $thumbnail = $this->profileImageUpdate($request, $garansi);

        $garansi->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            'garansi_photo_id' => $thumbnail ? $thumbnail->id : null,
            "driving_lience" =>$request->driving_lience,
            "date_of_birth" =>$request->date_of_birth,
        ]);
    }

    private function profileImageUpdate($request, $garansi)
    {
        $thumbnail = $garansi->profilePhoto;
        if ($request->hasFile('profile_photo') && $thumbnail == null) {
            $thumbnail = (new MediaRepository())->storeByRequest(
                $request->profile_photo,
                $this->path,
                'customer images',
                'image'
            );
        }

        if ($request->hasFile('profile_photo') && $thumbnail) {
            $thumbnail = (new MediaRepository())->updateByRequest(
                $request->profile_photo,
                $this->path,
                'image',
                $thumbnail
            );
        }

        return $thumbnail;
    }

    public function toggleStatus(Garansi $garansi)
    {
        $garansi->update([
            'is_active' => !$garansi->is_active
        ]);
        return $garansi;
    }
}
