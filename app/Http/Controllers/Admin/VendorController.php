<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index() {
        $data = Vendor::all();
        return view('admin.vendor.index', compact('data'));
    }

    public function create()
    {
        $vendor = Vendor::pluck('id_user')->toArray();
        $data = User::whereHas('roles', function($q) {
            $q->where('roles.id', '4')
            ->where('role_user.status', 1);
        })->whereNotIn('users.id', $vendor)
        ->get();
        return view('admin.vendor.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'    => 'required',
            'nama'     => 'required|string|max:30',
            'deskripsi'    => 'required|string|max:100'
        ]);
        
        try {
            $vendor = Vendor::create([
                'nama'     => $request->nama,
                'deskripsi'    => $request->deskripsi,
                'id_user'   => $request->id_user,
            ]);

        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data vendor: ' . $e->getMessage()));
        }
        
        return redirect()->route('admin.vendor')
                        ->with('success', 'vendor berhasil ditambahkan.');
    }

    protected function edit($id)
    {
        $old = Vendor::where('id', $id)->get();
        return view('admin.vendor.edit', compact('id', 'old'));
    }

    protected function update(Request $request)
    {
        $validated = Validator::make($request->all(), $this->rules($request->id));
        if($validated->fails()) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            Vendor::where('id', $request->id)->update($validated->validated());
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data vendor: ' . $e->getMessage()));
        }
        return redirect()->route('admin.vendor')
                        ->with('success', 'vendor berhasil ubah.');
    }

    protected function rules($id = null)
    {
        $uniqueRule = $id ?
            'unique:vendor,name,' . $id . ',id' :
            'unique:vendor,name';

        if($id != null) {
            return [
            'name' => [
                'required',
                'string',
                'max:50',
                'min:3',
                $uniqueRule
            ],
            'email' => [
                'required',
                'string',
                'max:200'
            ],
            'id' => [
                'required',
                'string',
                'max:8'
            ],
        ];
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'email' => [
                'required',
                'string',
                'max:3',
            ],
        ];
    }

    protected function destroy($id)
    {
        if (!Vendor::where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            Vendor::where('id', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data vendor: ' . $e->getMessage()));
        }
    }
}
