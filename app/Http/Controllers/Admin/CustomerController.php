<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index() 
    {
        $data = Customer::leftJoin('reg_provinces as p', 'customer.id_provinsi', 'p.id')->leftJoin('reg_regencies as r', 'customer.id_kota', 'r.id')->leftJoin('reg_districts as d', 'customer.id_kecamatan', 'd.id')->leftJoin('reg_villages as v', 'customer.id_kelurahan', 'v.id')->select('customer.id_customer', 'customer.nama', 'customer.alamat', 'p.name as provinsi', 'r.name as kota', 'd.name as kecamatan', 'v.name as kelurahan')->get();
        return view('admin.customer.index', compact('data'));
    }

    public function createBlob() 
    {
        $provinsi = DB::table('reg_provinces')->get();
        return view('admin.customer.create-blob', compact('provinsi'));
    }
    public function createPath() 
    {
        $provinsi = DB::table('reg_provinces')->get();
        return view('admin.customer.create-path', compact('provinsi'));
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

    public function storeBlob(Request $request)
    {
        try {
            // return response()->json($request->all());
            $request->validate([
                'nama' => 'required|string|max:50',
                'alamat' => 'required|string',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'kelurahan' => 'required|string',
                'foto_blob' => 'nullable'
            ]);

            $imageBinary = null;

            if ($request->foto_blob) {
                $image = $request->foto_blob;
                $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                $image = str_replace(' ', '+', $image);
                
                // langsung decode di sisi PostgreSQL
                $imageBinary = DB::raw("decode('" . $image . "', 'base64')");
            }

            $customer = Customer::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'id_provinsi' => $request->provinsi,
                'id_kota' => $request->kota,
                'id_kecamatan' => $request->kecamatan,
                'id_kelurahan' => $request->kelurahan,
                'foto_blob' => $imageBinary
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Customer berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data',
                'error' => mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8')
                // atau lebih aman:
                // 'error' => class_basename($e) . ': ' . substr($e->getMessage(), 0, 200)
            ], 500);
        }
    }

    public function storePath(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'foto' => 'nullable|image|max:2048'
            ]);

            $path = null;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('customers', 'public');
            }

            Customer::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'id_provinsi' => $request->provinsi,
                'id_kota' => $request->kota,
                'id_kecamatan' => $request->kecamatan,
                'id_kelurahan' => $request->kelurahan,
                'foto_path' => $path
            ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data',
            ], 500);
        }
    }
    public function getFoto($id)
    {
        $data = Customer::leftJoin('reg_provinces as p', 'customer.id_provinsi', 'p.id')->leftJoin('reg_regencies as r', 'customer.id_kota', 'r.id')->leftJoin('reg_districts as d', 'customer.id_kecamatan', 'd.id')->leftJoin('reg_villages as v', 'customer.id_kelurahan', 'v.id')->where('id_customer', $id)->select('customer.id_customer', 'customer.nama', 'customer.alamat', 'customer.foto_blob', 'customer.foto_path', 'p.name as provinsi', 'r.name as kota', 'd.name as kecamatan', 'v.name as kelurahan')->first();
        // Di controller yang load data customer
        if($data->foto_blob) {
            $foto = $data->foto_blob;
            if (is_resource($foto)) {
                $foto = stream_get_contents($foto);
            }
            $fotoResult = base64_encode($foto);
        } else {
            $fotoResult = $data->foto_path;
            $path = '/storage/';
            
        }
        return response()->json([
            'status' => 'success',
            'foto' => $fotoResult,
            'path' => $path ?? null,
        ]);
    }
}
