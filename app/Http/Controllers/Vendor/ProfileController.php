<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $id_user = Auth::user()->id;
        $data = Vendor::where('id_user', $id_user)->first();
        return view('vendor.profile.index', compact('data'));
    }
}
