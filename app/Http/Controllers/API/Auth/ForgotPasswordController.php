<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\UserMailEvent;
use App\Repositories\SMS;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\VerificationCodeRepository;
use App\Http\Requests\ForgotPasswordOtpVerifyRequest;

class ForgotPasswordController extends Controller
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

    public function verifyOtp(ForgotPasswordOtpVerifyRequest $request)
    {
        // $mobile = formatMobile($request->mobile);
        $contact = $request->contact;

        $user = $this->userRepo->findByContact($contact);

        if (!$user) {
            return $this->json('Sorry! No user found with this contact.', [], Response::HTTP_BAD_REQUEST);
        }

        $verificationCode = $this->verificationCodeRepo->checkCode($request->contact, $request->otp);

        if (!$verificationCode){
            return $this->json('Invalid OTP', [], Response::HTTP_BAD_REQUEST);
        }

        return $this->json('Otp matched successfully!', [
            'token' => $verificationCode->token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $verifyCode = $this->verificationCodeRepo->checkByToken($request->token);

        if (!$verifyCode) {
            return $this->json('Invalid token', [], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepo->findByContact($verifyCode->contact);

        if (!$user) {
            return $this->json('Sorry! No user found with this contact.', [], Response::HTTP_BAD_REQUEST);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $verifyCode->delete();

        return $this->json('Password reset successfully!');
    }
}
