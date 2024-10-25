<?php

namespace App\Http\Controllers\Mobile\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLoginRequest as LoginRequest;

use App\Http\Requests\MobileLoginRequest as MobileLoginRequest;

class LoginMobileController extends Controller
{
    public function index()
    {
        return view('auth.mobile');
    }

    public function login(MobileLoginRequest $loginRequest)
    {
        $user = $this->isAuthenticate($loginRequest);
        $loginRequest->only('email', 'password');

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => ["Invalid credentials"]])
                ->withInput();
        }

        Auth::login($user);
        return redirect()->route('root');
    }

    private function isAuthenticate($loginRequest)
    {
        $user = (new UserRepository())->findByContact($loginRequest->email);
        if (!is_null($user) && $user->is_active && Hash::check($loginRequest->password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function logout()
    {
        $user = auth()->user();
        Auth::logout($user);
        return redirect()->route('mobile');
    }

}
