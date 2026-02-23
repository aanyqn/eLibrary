<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboarUserController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->select('email_verified_at')->first();
        if(is_null($user->email_verified_at)) {
            return view('otp.index');
        }
        return view('user.index');
    }
}
