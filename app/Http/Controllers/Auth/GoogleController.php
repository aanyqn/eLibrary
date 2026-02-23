<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $findUser = User::where('id_google', $user->id)->first();
        if (!is_null($findUser)) {
            Auth::login($findUser);
        }
        else {
            $findUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'id_google' => $user->id,
                'password' => Hash::make('elibrary123')
            ]);
            $findUser->roles()->attach(3, [
                'status' => 1
            ]);
            Auth::login($findUser);
        }

        if(!Auth::check()) {
        return redirect()->back();
        }

        if (!is_null($findUser->email_verified_at)) {
            return redirect()->route('user.dashboard');
        }

        $otp = random_int(100000, 999999);
        User::where('id_google', $user->id)->update(['otp' => $otp]);
        Mail::to($user->email)->send(new OtpMail($otp));
        return view('otp.index');
    }
}
