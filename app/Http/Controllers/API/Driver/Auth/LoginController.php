<?php

namespace App\Http\Controllers\API\Driver\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\DriverDeviceKey;
use App\Models\User;
use App\Repositories\DriverDeviceKeyRepository;
use App\Repositories\DriverRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if ($user = $this->authenticate($request)) {
            if ($key = $request->device_key) {
                $exists = $this->findByKey($key);
                if (!$exists) {
                    $exists = DriverDeviceKey::create([
                        'driver_id' => $user->driver->id,
                        'key' => $key
                    ]);
                }
            }
            return $this->json('Log In Successfull', [
                'user' => new UserResource($user),
                'access' => (new UserRepository)->getAccessToken($user)
            ]);
        }
        return $this->json('Credential is invalid!', [], Response::HTTP_BAD_REQUEST);
    }

    private function authenticate(LoginRequest $request)
    {
        $user = (new UserRepository)->findActiveByContact($request->contact);
        if (!is_null($user) && $user->driver) {
            if (Hash::check($request->password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public function findByKey($key)
    {
        return DriverDeviceKey::where('key', $key)->first();
    }

    public function logout()
    {
        $user = auth()->user();
        if (\request()->device_key) {
            (new DriverDeviceKeyRepository())->destroy(\request()->device_key);
        }
        if ($user) {
            $user->token()->revoke();
            return $this->json('Logged out successfully!');
        }
        return $this->json('No Logged in user found', [], Response::HTTP_UNAUTHORIZED);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = (new DriverRepository())->changePasswordByRequest($request, auth()->user());
        if ($user) {
            return $this->json('Password change successfully', [
                'user' => (new UserResource($user))
            ]);
        }
        return $this->json('Incurrect password', [], Response::HTTP_BAD_REQUEST);
    }

    public function show()
    {
       $user = auth()->user();
       return $this->json('user details', [
            'user' => new UserResource($user)
        ]);
    }

    public function delete(User $user)
    {
        $driver = $user->driver;
        $driver->driverDevices()->delete();
        $orders = $driver->orders;
        foreach ($orders as $order) {
            $order->drivers()->detach($driver->id);
        }
        $driver->orderHistories()->delete();
        $driver->delete();

        $photo = $user->profilePhoto;
        if ($photo) {
            if (Storage::exists($photo->src)) {
                Storage::delete($photo->src);
            }
            $photo->delete();
        }
        $user->delete();

        return $this->json('Account Delete Successfully', []);
    }
}
