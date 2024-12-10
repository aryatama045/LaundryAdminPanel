<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminLoginRequest as LoginRequest;

use App\Http\Requests\RegistrationRequest;

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


    public function daftar_action(RegistrationRequest $request)
    {
        $user = (new UserRepository())->registerUser($request);
        (new CustomerRepository())->storeByUser($user);

        $user->update([
            'mobile_verified_at' => now(),
            'is_active' => false
        ]);

        $user->assignRole('Customer');
        $user->givePermissionTo('root');
        $user->givePermissionTo('customer.index');
        $user->givePermissionTo('customer.show');
        $user->givePermissionTo('customer.edit');
        $user->givePermissionTo('customer.update');
        $user->givePermissionTo('customer.create');
        $user->givePermissionTo('customer.store');

        $user->givePermissionTo('garansi.index');
        $user->givePermissionTo('garansi.show');
        $user->givePermissionTo('garansi.edit');
        $user->givePermissionTo('garansi.update');
        $user->givePermissionTo('garansi.create');
        $user->givePermissionTo('garansi.store');

        $user->givePermissionTo('klaim.index');
        $user->givePermissionTo('klaim.show');
        $user->givePermissionTo('klaim.edit');
        $user->givePermissionTo('klaim.update');
        $user->givePermissionTo('klaim.create');
        $user->givePermissionTo('klaim.store');
        $user->givePermissionTo('klaim.check_validasi');

        return redirect()->route('customer.index')->with('success', 'Customer create successfully');
    }

    public function daftar_sukses()
    {
        return view('auth.suksesDaftar');
    }

    public function lupa_password()
    {
        return view('auth.lupaPassword');
    }

    public function lupa_password_action()
    {
        return view('auth.daftar');
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
