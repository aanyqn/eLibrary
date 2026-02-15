<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $book = new Book();
        $data = $book->data();
        return view('admin.book.index', compact('data'));
    }
    public function create()
    {
        $category = New Category();
        $data_category = $category->data();
        return view('admin.book.create', compact('data_category'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateBook($request);
        $buku = $this->createBook($validatedData);
        return redirect()->route('admin.book')
                        ->with('success', 'buku berhasil ditambahkan.');
    }

    protected function validateBook(Request $request, $id = null)
    {
        $uniqueRule = $id ?
            'unique:buku,judul,' . $id . ',idbuku' :
            'unique:buku,judul';

        if($id != null) {
            return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                'min:3',
            ],
            'judul' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'pengarang' => [
                'required',
                'string',
                'max:200',
                'min:3',
            ],
            'idkategori' => [
                'required',
                'numeric'
            ],
            'idbuku' => [
                'required',
                'numeric'
            ]

        ], [
            'judul.required' => 'Nama book wajib diisi',
            'judul.string' => 'Nama book harus berupa teks',
            'judul.max' => 'Nama book max 255 karakter',
            'judul.min' => 'Nama book minimal 3 karakter',
            'judul.unique' => 'Nama book sudah ada',
        ]);
        }

        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                'min:3',
            ],
            'judul' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'pengarang' => [
                'required',
                'string',
                'max:200',
                'min:3',
            ],
            'idkategori' => [
                'required',
                'numeric'
            ],

        ], [
            'judul.required' => 'Nama book wajib diisi',
            'judul.string' => 'Nama book harus berupa teks',
            'judul.max' => 'Nama book max 255 karakter',
            'judul.min' => 'Nama book minimal 3 karakter',
            'judul.unique' => 'Nama book sudah ada',
        ]);
    }

    protected function createBook(array $data)
    {
        try {
            
            $buku = DB::table('buku')->insert([
                'kode' => $data['kode'],
                'judul' => $this->formatJudul($data['judul']),
                'pengarang' => $data['pengarang'],
                'idkategori' => $data['idkategori'],
            ]);
            return $buku;
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
        }
    }
    protected function edit($id)
    {
        return view('admin.book.edit', compact('id'));
    }

    protected function update(Request $request)
    {
        $validatedData = $this->validateBook($request, $request['idjenis_hewan']);
        $buku = $this->updateJenisHewan($validatedData);
        return redirect()->route('admin.book.index')
                        ->with('success', 'book berhasil ubah.');
    }
    protected function updateJenisHewan(array $data)
    {
        try {
            $buku = DB::table('buku')->where('idjenis_hewan', $data['idjenis_hewan'])->update([
                'judul' => $this->formatJudul($data['judul'])
            ]);
            return $buku;
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
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
            throw new \Exception(('Gagal menghapus data book: ' . $e->getMessage()));
        }
    }

    protected function formatJudul($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
