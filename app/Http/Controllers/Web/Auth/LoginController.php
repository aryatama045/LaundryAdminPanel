<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\DaftarMailEvent;
use App\Http\Requests\AdminLoginRequest as LoginRequest;

use App\Models\WebSetting;
use App\Models\VerificationCode;

use App\Events\UserMailEvent;
use App\Events\ForgotPasswordEvent;

use App\Repositories\SMS;
use Illuminate\Http\Response;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\VerificationCodeRepository;
use App\Http\Requests\ForgotPasswordOtpVerifyRequest;

use App\Http\Requests\RegistrationRequest;

class LoginController extends Controller
{
    /**
     * @var VerificationCodeRepository
     */
    private $verificationCodeRepo;

    private $userRepo;

    public function __construct(VerificationCodeRepository $verificationCodeRepo, UserRepository $userRepo)
    {
        $this->verificationCodeRepo = $verificationCodeRepo;
        $this->userRepo = $userRepo;
    }

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
            'kode_unik' => $request->kode_unik ? $request->kode_unik : null,
            'kode_customer' => $request->kode_customer ? $request->kode_customer : null,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
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

        // DaftarMailEvent::dispatch($user);

        UserMailEvent::dispatch($user, 'Sukses');

        return redirect()->route('daftar_sukses')->with('success', 'Customer create successfully');
    }

    public function daftar_sukses()
    {
        return view('auth.suksesDaftar');
    }

    public function lupa_password()
    {
        return view('auth.lupaPassword');
    }

    public function lupa_password_action(Request $request)
    {
        $contact = $request->email;

        $user = $this->userRepo->findByContact($contact);

        if (!$user) {
            return redirect()->route('lupa_password')->with('error', 'Sorry! No user found with this contact.');
        }

        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        $message = 'Hello '. $user->name . '. Your password reset OTP is '. $verificationCode->otp ;

        // (new SMS())->sendSms($mobile, $message);
        $setting = WebSetting::first();

        ForgotPasswordEvent::dispatch($setting, $user, $verificationCode->token);

        #todo create an event send
        return redirect()->route('login')->with('success', 'Success send Code Verification to your email');

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



    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $contact = $request->contact;

        $user = $this->userRepo->findByContact($contact);

        if (!$user) {
            return $this->json('Sorry! No user found with this contact.', [], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        $message = 'Hello '. $user->name . '. Your password reset OTP is '. $verificationCode->otp ;

        // (new SMS())->sendSms($mobile, $message);
        UserMailEvent::dispatch($user, $verificationCode->otp);

        #todo create an event send otp to mobile

        return $this->json('We sent otp to your contact',[
            'otp' => $verificationCode->otp
        ]);
    }



    public function verifyOtp($token)
    {
        // $mobile = formatMobile($request->mobile);

        $getUser = VerificationCode::where('token', $token)->get();
        dd($token, $getUser);
        if (!$getUser) {
            return redirect()->route('lupa_password')->with('error', 'Sorry! No user found with this verify token.');
        }

        $verificationCode = $this->verificationCodeRepo->checkCode($getUser->email, $request->otp);

        if (!$verificationCode){
            return redirect()->route('lupa_password')->with('error', 'Sorry! No user found with this verify token.');
        }

        $tokens = $verificationCode->token;
        return view('auth.resetPassword', compact('tokens'));

    }

    public function reset_password_action(ResetPasswordRequest $request)
    {
        $verifyCode = $this->verificationCodeRepo->checkByToken($request->token);

        $user = $this->userRepo->findByContact($verifyCode->email);

        if (!$user) {
            return redirect()->route('lupa_password')->with('error', 'Sorry! No user found with this verify token.');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $verifyCode->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }
}
