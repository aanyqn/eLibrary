<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index() {
        $data = Penjualan::all();
        return view('admin.penjualan.index', compact('data'));
    }

    public function create() {
        return view('admin.penjualan.create');
    }
    public function createAxios() {
        return view('admin.penjualan.createAxios');
    }

    public function barang($idbarang) {
        $data = DB::table('barang')->whereLike('id_barang', $idbarang)->first();
        return response()->json([
            'status' => 'success',
            'data' => [
                'barang' => $data
            ]
        ]);
    }

   public function store(Request $request)
    {
        try {
            $penjualan = Penjualan::create([
                'total' => $request->total
            ]);

            foreach ($request->items as $item) {
                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([        // Error akan muncul di browser
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
}
