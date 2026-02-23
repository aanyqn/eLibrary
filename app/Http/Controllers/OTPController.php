<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OTPController extends Controller
{
    public function verify(Request $request) 
    {
        $validate = $request->validate([
            'char1' => [
                'required',
                'numeric'
            ],
            'char2' => [
                'required',
                'numeric'
            ],
            'char3' => [
                'required',
                'numeric'
            ],
            'char4' => [
                'required',
                'numeric'
            ],
            'char5' => [
                'required',
                'numeric'
            ],
            'char6' => [
                'required',
                'numeric'
            ]
        ]);
        $id = auth()->user()->id;
        $otp = User::where('id', $id)->select('otp')->first();
        $inputOtp = $request->char1.$request->char2.$request->char3.$request->char4.$request->char5.$request->char6;
        if($inputOtp == $otp->otp) {
            $updateUser = User::where('id', $id)->update([
                'email_verified_at' => now()
            ]);
            return redirect()->route('user.dashboard');
        }

    } 

    public function resendOTP() 
    {
        $user = auth()->user()->email;
        $otp = random_int(100000, 999999);
        $resendOtp = User::where('email', $user->email)->update(['otp' => $otp]);
        Mail::to($user->email)->send(new OtpMail($otp));
        return $resendOtp;
    }
}
