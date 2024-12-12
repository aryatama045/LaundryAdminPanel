<?php


namespace App\Repositories;

use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\CustomerGaransiRequest;
use App\Models\CustomerGaransis;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use DB;

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

        $user_id = auth()->user()->getRelations('roles');
        $user_id = $user_id['roles'][0]->name;


        $garansis = $this->model()::query();

        if($user_id == 'customer'){
            $userid = auth()->user()->id;

            $cst = Customer::where('user_id', $userid)->first();

            $cst_id = $cst->id;


            $garansis = $garansis->Join('orders','customer_garanses.customer_id = orders.customer_id')
                        ->where('customer_id', '=', $cst_id);
        }


        if ($searchKey) {
            $garansis = $garansis->whereHas('user', function ($garansi) use ($searchKey) {
                $garansi->where('first_name', 'like', "%{$searchKey}%")
                    ->orWhere('no_nota', 'like', "%{$searchKey}%")
                    ->orWhere('no_pemasangan', 'like', "%{$searchKey}%");
            });
        }

        return $garansis->latest('id')->get();
    }

    public function storeByGaransi(CustomerGaransis $request): CustomerGaransis
    {
        return $this->create([
            'customer_id' => $request->customer_id,
            'no_nota' => $request->no_nota,
            'tanggal_nota' => $request->tanggal_nota,
            'no_pemasangan' => $request->no_pemasangan,
            'tanggal_pemasangan' => $request->tanggal_pemasangan,
        ]);

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

}
