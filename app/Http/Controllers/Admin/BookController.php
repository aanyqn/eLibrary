<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $data = Book::all();
        return view('admin.book.index', compact('data'));
    }
    public function create()
    {
        $data_category = Category::all();
        return view('admin.book.create', compact('data_category'));
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
            Book::create($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
        }
        
        return redirect()->route('admin.book')
                        ->with('success', 'buku berhasil ditambahkan.');
    }

    protected function edit($id)
    {
        $old = Book::where('idbuku', $id)->get();
        $data_category = Category::all();
        return view('admin.book.edit', compact('id', 'old', 'data_category'));
    }

    protected function update(Request $request)
    {
        $validated = $request->validate($this->rules($request->idbuku));
        if(!$validated) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            Book::where('idbuku', $request->idbuku)->update($validated);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data book: ' . $e->getMessage()));
        }
        return redirect()->route('admin.book')
                        ->with('success', 'book berhasil ubah.');
    }

    protected function rules($id = null)
    {
        $uniqueRule = $id ?
            'unique:buku,judul,' . $id . ',idbuku' :
            'unique:buku,judul';

        if($id != null) {
            return [
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
        ];
        }

        return [
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
            ]
        ];
    }

    protected function destroy($id)
    {
        if (!Book::where('idbuku', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            Book::where('idbuku', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data book: ' . $e->getMessage()));
        }
    }
}
