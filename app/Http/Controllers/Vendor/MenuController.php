<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $vendor = Vendor::where('id_user', Auth::user()->id)->select('id_vendor')->first();
        $data = Menu::where('id_vendor', $vendor->id_vendor)->get();
        return view('vendor.menu.index', compact('data'));
    }
    public function create()
    {
        return view('vendor.menu.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:30',
            'deskripsi'     => 'required|string|max:200',
            'harga'    => 'required|numeric',
            'path_gambar' => 'nullable|image|mimes:png,jpg|max:2048'
        ]);
        $vendor = Vendor::where('id_user', Auth::user()->id)->select('id_vendor')->first();
        $image_path = null;
        if($request->hasFile('path_gambar')) {
            $image_path = $request->file('path_gambar')->store('photos', 'public');
        }
        
        try {
            $menu = Menu::create([
                'nama'     => $request->nama,
                'deskripsi'    => $request->deskripsi,
                'harga'   => $request->harga,
                'id_vendor' => $vendor->id_vendor,
                'path_gambar' => $image_path
            ]);

        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data menu: ' . $e->getMessage()));
        }
        
        return redirect()->route('vendor.menu')
                        ->with('success', 'menu berhasil ditambahkan.');
    }

    protected function edit($id)
    {
        $old = Menu::where('id_menu', $id)->get();
        return view('vendor.menu.edit', compact('id', 'old'));
    }

    protected function update(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:30',
            'deskripsi'     => 'required|string|max:200',
            'harga'    => 'required|numeric',
            'path_gambar' => 'nullable|image|mimes:png,jpg|max:2048',
            'id_menu' => 'required|numeric'
        ]);

        $path = Menu::where('id_menu', $request->id_menu)->select('path_gambar')->first();
        $image_path = $path->path_gambar;
        if($request->hasFile('path_gambar')) {
            $image_path = $request->file('path_gambar')->store('photos', 'public');
        }  
        try {

            $menu = Menu::where('id_menu', $request->id_menu)->update([
                'nama'     => $request->nama,
                'deskripsi'    => $request->deskripsi,
                'harga'   => $request->harga,
                'path_gambar' => $image_path
            ]);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data menu: ' . $e->getMessage()));
        }
        return redirect()->route('vendor.menu')
                        ->with('success', 'menu berhasil ubah.');
    }
}