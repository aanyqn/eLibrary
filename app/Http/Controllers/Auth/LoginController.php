<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = DB::table('users')
            ->where('email', $request->input('email'))
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email tidak ditemukan'])
                ->withInput();
        }
        // $password = Hash::make($request->password);
        // dd($user, $password);

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password salah'])
                ->withInput();
        }

        $namaRole = DB::table('role')->where('idrole', $user->idrole)->first();


        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $user->idrole ?? 'user',
            'user_role_name' => $namaRole->nama_role ?? 'User',
        ]);

        $userRole = $user->idrole ?? null;
        switch ($userRole) {
            case '1':
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Behasil logout');
    }
}
