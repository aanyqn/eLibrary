<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function index() {
        return view('admin.ajax.index');
    }

    public function submit(Request $req) {
        $data = $req->nama;
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data received successfully',
            'data' => [
                'name' => $data
            ]
        ]);
    }

    public function cascadeSelectAjax() {
        $provinsi = DB::table('reg_provinces')->get();
        return view('admin.kota.ajax', compact('provinsi'));
    } 

    public function cascadeSelectAxios() {
        $provinsi = DB::table('reg_provinces')->get();
        return view('admin.kota.axios', compact('provinsi'));
    }
    
    public function kota($provinsi_id) {
        $data = DB::table('reg_regencies')->where('province_id', $provinsi_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'kota' => $data
            ]
        ]);
    }

    public function kecamatan($kota_id) {
        $data = DB::table('reg_districts')->where('regency_id', $kota_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'kecamatan' => $data
            ]
        ]);
    }

    public function kelurahan($kecamatan_id) {
        $data = DB::table('reg_villages')->where('district_id', $kecamatan_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => [
                'kelurahan' => $data
            ]
        ]);
    }
}
