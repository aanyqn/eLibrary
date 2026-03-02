<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::all();
        return view('admin.barang.index', compact('data'));
    }
    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        if(!$validated) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            Barang::create($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data barang: ' . $e->getMessage()));
        }
        
        return redirect()->route('admin.barang')
                        ->with('success', 'barang berhasil ditambahkan.');
    }

    protected function edit($id)
    {
        $old = Barang::where('id_barang', $id)->get();
        return view('admin.barang.edit', compact('id', 'old'));
    }

    protected function update(Request $request)
    {
        $validated = $request->validate($this->rules($request->id_barang));
        if(!$validated) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            Barang::where('id_barang', $request->id_barang)->update($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data barang: ' . $e->getMessage()));
        }
        return redirect()->route('admin.barang')
                        ->with('success', 'barang berhasil ubah.');
    }

    protected function rules($id = null)
    {
        $uniqueRule = $id ?
            'unique:barang,nama,' . $id . ',id_barang' :
            'unique:barang,nama';

        if($id != null) {
            return [
            'nama' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'harga' => [
                'required',
                'numeric',
            ],
            'id_barang' => [
                'required',
                'string',
                'max:8'
            ],
        ];
        }

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'harga' => [
                'required',
                'numeric',
            ],
        ];
    }

    protected function destroy($id)
    {
        if (!Barang::where('id_barang', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            Barang::where('id_barang', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data barang: ' . $e->getMessage()));
        }
    }
}
