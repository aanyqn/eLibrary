<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return view('admin.category.index', compact('data'));
    }
    public function create()
    {
        return view('admin.category.create');
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
            Category::create($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
        }
        return redirect()->route('admin.category')
                        ->with('success', 'category berhasil ditambahkan.');
    }

     protected function edit($id)
    {
        return view('admin.category.edit', compact('id'));
    }

    protected function update(Request $request)
    {
        $validated = $request->validate($this->rules($request->idkategori));
        if(!$validated) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            Category::where('idkategori', $request->idkategori)->update($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
        }
        return redirect()->route('admin.category')
                        ->with('success', 'category berhasil ubah.');
    }

    protected function rules($id = null)
    {
        $uniqueRule = $id ?
            'unique:kategori,nama_kategori,' . $id . ',idkategori' :
            'unique:kategori,nama_kategori';

        if($id != null) {
            return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'idkategori' => [
                'required',
                'numeric'
            ]

        ];
        }
        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],

        ];
    }


    protected function destroy($id)
    {
        if (!Category::where('idkategori', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            Category::where('idkategoti', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data category: ' . $e->getMessage()));
        }
    }

    // protected function formatNamaKategori($nama)
    // {
    //     return trim(ucwords(strtolower($nama)));
    // }
}
