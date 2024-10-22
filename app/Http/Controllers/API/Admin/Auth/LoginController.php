<?php

namespace App\Http\Controllers\API\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLoginRequest as LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\AdminDeviceKey;
use App\Repositories\DeviceKeyRepository;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function findByKey($key)
    {
        return AdminDeviceKey::where('key',$key)->first();
    }

    public function login(LoginRequest $loginRequest)
    {
        $user = $this->isAuthenticate($loginRequest);
        $credentials = $loginRequest->only('email', 'password');

        if ($user) {
            if($key = $loginRequest->device_key){
                $exists = $this->findByKey($key);
                if(!$exists){
                    $exists = AdminDeviceKey::create([
                        'user_id' => $user->id,
                        'key' => $key
                    ]);
                }
            }

            return $this->json('Log In Successfull', [
                'user' => (new UserResource($user)),
                'access' => (new UserRepository())->getAccessToken($user)
            ]);
        }
        return $this->json('Credential is invalid!', [], Response::HTTP_BAD_REQUEST);
    }

    private function isAuthenticate($loginRequest)
    {
        $user = (new UserRepository())->findByContact($loginRequest->email);
        if(!is_null($user) && Hash::check($loginRequest->password, $user->password)){
            return $user;
        }
        return false;
    }

    public function logout()
    {
        $user = auth()->user();

        if(\request()->device_key){
            $exists = $this->findByKey(\request()->device_key);
            if ($exists) {
               $exists->delete();
            }
        }

        if ($user) {
            $user->token()->revoke();
            return $this->json('Logged out successfully!');
        }
        return $this->json('No Logged in user found', [], Response::HTTP_UNAUTHORIZED);
    }
}
