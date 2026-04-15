<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Detail_Pesanan;
use App\Models\Pesanan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $vendor = Vendor::where('id_user', Auth::user()->id)->select('id_vendor')->first();
        $data = Pesanan::leftJoin('detail_pesanan as dp', 'pesanan.id_pesanan', '=', 'dp.id_pesanan')->leftJoin('menu as m', 'dp.id_menu', '=', 'm.id_menu')->where('m.id_vendor', $vendor->id_vendor)->where('pesanan.status_bayar', 1)->whereDate('pesanan.created_at', today())->orderByDesc('pesanan.created_at')->select('pesanan.order_id', 'pesanan.id_pesanan', 'pesanan.nama as customer', 'm.nama as menu', 'dp.status_pesanan')->get();
        return view('vendor.pesanan.index', compact('data'));
    }

    public function changePesananStatus(Request $request)
    {
        $detail_pesanan = Detail_Pesanan::where('id_pesanan', $request->id)->first();
        if($detail_pesanan->status_pesanan == 0) {
            Detail_Pesanan::where('id_detail_pesanan', $detail_pesanan->id_detail_pesanan)->update([
                'status_pesanan' => 1
            ]);

            return response()->json([
                'status' => 'success',
                'detail_pesanan' => $detail_pesanan
            ]);
        }
        Detail_Pesanan::where('id_detail_pesanan', $detail_pesanan->id_detail_pesanan)->update([
            'status_pesanan' => 2
        ]);
        return response()->json([
            'status' => 'success',
            'detail_pesanan' => $detail_pesanan
        ]);
    }
}
