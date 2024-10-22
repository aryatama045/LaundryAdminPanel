<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\UserMailEvent;
use App\Repositories\SMS;
use Illuminate\Http\Response;
use App\Http\Requests\OTPRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ReSendOtpRequest;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\DeviceKeyRepository;
use App\Repositories\VerificationCodeRepository;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepo;
    /**
     * @var VerificationCodeRepository
     */
    private $verificationCodeRepo;

    public function __construct(UserRepository $userRepo, VerificationCodeRepository $verificationCodeRepository)
    {
        $this->userRepo = $userRepo;
        $this->verificationCodeRepo = $verificationCodeRepository;
    }

    public function register(RegistrationRequest $request)
    {

        $contact = $request->mobile ?? $request->email;

        $user = $this->userRepo->registerUser($request);

        (new CustomerRepository())->storeByUser($user);

        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        #todo create an event send otp to mobile

        $user->assignRole('customer');

        $user->update([
            'mobile_verified_at' => now()
        ]);

        if($request->device_key){
            (new DeviceKeyRepository())->storeByRequest($user->customer, $request);
        }

        $message = "Welcome to laundry \r\n
        Your otp verification code is " . $verificationCode->otp;

        // (new SMS())->sendSms($request->mobile, $message);
        UserMailEvent::dispatch($user, $verificationCode->otp);

        return $this->json('Registration successfully complete' , [
            'user' => new UserResource($user),
            'access' => $this->userRepo->getAccessToken($user),
            'otp' => $verificationCode->otp
        ]);
    }

    public function mobileVerify(OTPRequest $request)
    {
        // $contact = \formatMobile($request->contact);
        $contact = $request->contact;
        $user = $this->userRepo->findByContact($contact);
        $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);

        if (!is_null($user) && $verificationCode->otp == $request->otp) {
            $verificationCode->delete();
            $user->update([
                'mobile_verified_at' => now()
            ]);
            return $this->json('Mobile verification complete', [
                'user' => new UserResource($user)
            ]);
        }
        return $this->json('Invalid OTP or contact!', [], Response::HTTP_BAD_REQUEST);
    }

    public function login(LoginRequest $request)
    {
        if ($user = $this->authenticate($request)) {
            if ($user->customer) {
                if($request->device_key){
                    (new DeviceKeyRepository())->storeByRequest($user->customer, $request);
                }

                return $this->json('Log In Successfull', [
                    'user' => new UserResource($user),
                    'access' => $this->userRepo->getAccessToken($user)
                ]);
            }
        }
        return $this->json('Credential is invalid!', [], Response::HTTP_BAD_REQUEST);
    }

    public function logout()
    {
        $user = auth()->user();
        if(\request()->device_key){
            (new DeviceKeyRepository())->destroy(\request()->device_key);
        }

        if ($user) {
            $user->token()->revoke();
            return $this->json('Logged out successfully!');
        }
        return $this->json('No Logged in user found', [], Response::HTTP_UNAUTHORIZED);
    }

    private function authenticate(LoginRequest $request)
    {
        $user = $this->userRepo->findActiveBycontact($request->contact);

        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            return $user;
        }

        return false;
    }

    public function resendOTP(ReSendOtpRequest $request)
    {
        $contact = $request->contact;
        $user = $this->userRepo->findByContact($contact);

        if($user){
            $verificationCode = $this->verificationCodeRepo->findOrCreateByContact($contact);
            $message = "Hello \r\n". $user->name . 'Your password reset otp is '. $verificationCode->otp ;

            // (new SMS())->sendSms($request->contact, $message);
            UserMailEvent::dispatch($user, $verificationCode->otp);

            return $this->json('Verification code is resent success to your contact',[
                'otp' => $verificationCode->otp
            ]);
        }

        return $this->json('Sorry, your contact is not found!');
    }
}
