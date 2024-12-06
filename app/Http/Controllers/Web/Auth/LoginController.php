<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLoginRequest as LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function daftar()
    {
        return view('auth.daftar');
    }

    public function lupa_password()
    {
        return view('auth.lupaPassword');
    }

    public function login(LoginRequest $loginRequest)
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
        return redirect()->route('login');
    }
}
