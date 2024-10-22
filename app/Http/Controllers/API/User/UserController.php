<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfilePhotoRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\DriverRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function update(UserRequest $request)
    {
        $user = (new UserRepository())->updateByRequest($request, auth()->user());

        return $this->json('Profile is updated successfully', [
            'user' => (new UserResource($user))
        ]);
    }
    public function updateProfilePhoto(ProfilePhotoRequest $request)
    {
        $user = (new UserRepository())->updateProfilePhotoByRequest($request, auth()->user());

        return $this->json('Profile photo is updated successfully', [
            'user' => (new UserResource($user))
        ]);
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = (new DriverRepository())->changePasswordByRequest($request, auth()->user());
        if ($user) {
            return $this->json('Password change successfully', [
                'user' => (new UserResource($user))
            ]);
        }
        return $this->json('Incurrect password', [], Response::HTTP_BAD_REQUEST);
    }
}
