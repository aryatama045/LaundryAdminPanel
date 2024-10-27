<?php


namespace App\Repositories;

use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    private $path = 'images/customers/';
    public function model()
    {
        return User::class;
    }

    public function registerUser(Request $request)
    {
        $thumbnail = null;
        if ($request->hasFile('profile_photo')) {
            $thumbnail = (new MediaRepository())->storeByRequest(
                $request->profile_photo,
                $this->path,
                'customer images',
                'image'
            );
        }

        $user = $this->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company' => $request->company ? $request->company : null,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'profile_photo_id' =>  $thumbnail ? $thumbnail->id : null,
            'driving_lience' =>$request->driving_lience,
            'date_of_birth' =>$request->date_of_birth,
            'is_active' => true,
        ]);

        return $user;
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

    public function getAccessToken(User $user)
    {
        $token = $user->createToken('user token');
        return [
            'auth_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->format('Y-m-d H:i:s'),
        ];
    }

    public function updateByRequest(UserRequest $request, $user): User
    {
        $thumbnail = $this->profileImageUpdate($request, $user);

        $user->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            'mobile' => $request->mobile,
            "gender" => $request->gender,
            "alternative_phone" => $request->alternative_phone,
            'profile_photo_id' => $thumbnail ? $thumbnail->id : null,
            "driving_lience" =>$request->driving_lience,
            "date_of_birth" =>$request->date_of_birth,
        ]);

        return $user;
    }
    public function updateProfilePhotoByRequest(ProfilePhotoRequest $request, $user): User
    {
        $thumbnail = (new MediaRepository())->storeByRequest(
            $request->profile_photo,
            $this->path,
            'customer images',
            'image'
        );

        $user->update([
            'profile_photo_id' => $thumbnail->id
        ]);

        return $user;
    }

    public function updateProfileByRequest($request, $user)
    {
        $thumbnail = $this->profileImageUpdate($request, $user);

        $user->update([
            "company" => $request->company,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            'profile_photo_id' => $thumbnail ? $thumbnail->id : null,
            "driving_lience" =>$request->driving_lience,
            "date_of_birth" =>$request->date_of_birth,
        ]);
    }

    private function profileImageUpdate($request, $user)
    {
        $thumbnail = $user->profilePhoto;
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

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);
        return $user;
    }
}
