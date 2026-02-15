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
        $category = new Category();
        $data = $category->data();
        return view('admin.category.index', compact('data'));
    }
    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateCategory($request);
        $kategori = $this->createCategory($validatedData);
        return redirect()->route('admin.category')
                        ->with('success', 'category berhasil ditambahkan.');
    }

    protected function validateCategory(Request $request, $id = null)
    {
        $uniqueRule = $id ?
            'unique:kategori,nama_kategori,' . $id . ',idkategori' :
            'unique:kategori,nama_kategori';

        if($id != null) {
            return $request->validate([
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

        ], [
            'nama_kategori.required' => 'Nama category wajib diisi',
            'nama_kategori.string' => 'Nama category harus berupa teks',
            'nama_kategori.max' => 'Nama category max 255 karakter',
            'nama_kategori.min' => 'Nama category minimal 3 karakter',
            'nama_kategori.unique' => 'Nama category sudah ada',
        ]);
        }

        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],

        ], [
            'nama_kategori.required' => 'Nama category wajib diisi',
            'nama_kategori.string' => 'Nama category harus berupa teks',
            'nama_kategori.max' => 'Nama category max 255 karakter',
            'nama_kategori.min' => 'Nama category minimal 3 karakter',
            'nama_kategori.unique' => 'Nama category sudah ada',
        ]);
    }

    protected function createCategory(array $data)
    {
        try {
            
            $kategori = DB::table('kategori')->insert([
                'nama_kategori' => $this->formatNamaKategori($data['nama_kategori'])
            ]);
            return $kategori;
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menyimpan data category: ' . $e->getMessage()));
        }
    }
    protected function edit($id)
    {
        return view('admin.category.edit', compact('id'));
    }

    protected function update(Request $request)
    {
        $validatedData = $this->validateCategory($request, $request['idjenis_hewan']);
        $kategori = $this->updateJenisHewan($validatedData);
        return redirect()->route('admin.category.index')
                        ->with('success', 'category berhasil ubah.');
    }
    protected function updateJenisHewan(array $data)
    {
        try {
            $kategori = DB::table('kategori')->where('idjenis_hewan', $data['idjenis_hewan'])->update([
                'nama_kategori' => $this->formatNamaKategori($data['nama_kategori'])
            ]);
            return $kategori;
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menyimpan data category: ' . $e->getMessage()));
        }
    }
    protected function destroy($id)
    {
        if (!JenisHewan::where('idjenis_hewan', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            RasHewan::where('idjenis_hewan', $id)->delete();
            JenisHewan::where('idjenis_hewan', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data category: ' . $e->getMessage()));
        }
    }

    protected function formatNamaKategori($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
