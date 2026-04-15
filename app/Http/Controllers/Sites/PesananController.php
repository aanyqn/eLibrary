<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Models\Detail_Pesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class PesananController extends Controller
{
    public function index()
    {
        $data = Menu::leftJoin('vendor', 'menu.id_vendor', 'vendor.id_vendor')->select('menu.*', 'menu.nama', 'menu.deskripsi','vendor.nama as nama_vendor', 'vendor.deskripsi as deskripsi_vendor')->get(); 
        $vendor = Vendor::all();
        
        $namaAkses = Auth::user()->nama ?? 'Guest';
        $pendingPesanan = Pesanan::where('nama', $namaAkses)
                            ->where('status_bayar', 0)
                            ->whereNotNull('snap_token')
                            ->orderBy('id_pesanan', 'desc')
                            ->first();

        return view('guest.pesanan.index', compact('data', 'vendor', 'pendingPesanan'));
    }

    public function vendorMenu($id_vendor)
    {
        if($id_vendor == 0) {
            $data = Menu::leftJoin('vendor', 'menu.id_vendor', 'vendor.id_vendor')->select('menu.*', 'menu.nama', 'menu.deskripsi','vendor.nama as nama_vendor', 'vendor.deskripsi as deskripsi_vendor')->get();
            return response()->json([
                'status' => 'success',
                'data' => [
                    'menu' => $data,
                ]
            ]);
        }
        $data = Menu::leftJoin('vendor', 'menu.id_vendor', 'vendor.id_vendor')->select('menu.*', 'menu.nama', 'menu.deskripsi','vendor.nama as nama_vendor', 'vendor.deskripsi as deskripsi_vendor')->where('vendor.id_vendor', $id_vendor)->get(); 
        return response()->json([
            'status' => 'success',
            'data' => [
                'menu' => $data,
            ]
        ]);
    }

    public function checkout(Request $request) 
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('app.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        try {
            $cart = $request->cart;
            $id_menu = collect($cart)->pluck('id_menu');
            $menu = Menu::whereIn('id_menu', $id_menu)->get();
            $menuMap = $menu->keyBy('id_menu');
            $pesanan = Pesanan::create([
                'nama' => Auth::user()->nama ?? 'Guest' . rand(1,9999),
                'total' => 0,
                'status_bayar' => 0,
                'status_pesanan' => 0
            ]);

            $total = 0;

            foreach ($cart as $item) {
                $menuItem = $menuMap[$item['id_menu']] ?? null;

                if (!$menuItem) continue; 

                $harga = $menuItem->harga;
                $qty = $item['qty'];
                $subtotal = $harga * $qty;

                Detail_Pesanan::create([
                    'id_menu' => $item['id_menu'],
                    'id_pesanan' => $pesanan->id_pesanan,
                    'jumlah' => $qty,
                    'harga' => $harga,
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            $orderId = 'TRX-' . time() . '-' . $pesanan->id_pesanan;


            $pesanan->update([
                'total' => $total,
                'order_id' => $orderId
                ]);

            $items = Detail_Pesanan::where('id_pesanan', $pesanan->id_pesanan)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->id_menu,
                                'price' => $item->harga,
                                'quantity' => $item->jumlah,
                                'name' => 'Menu ' . $item->id_menu // atau relasi menu
                            ];
                        })
                        ->toArray();

            $params = array(
                'transaction_details' => array(
                    'order_id' => $orderId,
                    'gross_amount' => $pesanan->total,
                ),
                'customer_details' => array(
                    'first_name' => $pesanan->nama,
                    'email' => Auth::user()->email ?? 'guest@mail.com'
                ),
                'item_details' => $items,
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $pesanan->update([
                'snap_token' => $snapToken
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil dibuat',
                'snapToken' => $snapToken,
                'id_pesanan' => $pesanan->id_pesanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function payment(Request $request)
    {
        if(is_null($request->result)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please pay first'
            ], 400);
        } elseif($request->result['transaction_status'] != 'capture' && $request->result['transaction_status'] != 'settlement') {
            return response()->json([
                'status' => 'error',
                'message' => 'Your payment is not done yet!'
            ], 400);
        }

        Pesanan::where('order_id', $request->result['order_id'])->update([
            'status_bayar' => 1,
            'metode_bayar' => $request->result['payment_type']
        ]);

        $id = Pesanan::where('order_id', $request->result['order_id'])->select('id_pesanan')->first();


        return response()->json([
            'status' => 'success',
            'id_pesanan' => $id->id_pesanan
        ]);
    }

    public function success($id)
    {
        $pesanan = Pesanan::where('id_pesanan',  $id)->first();
        $details = Detail_Pesanan::leftJoin('menu', 'menu.id_menu', 'detail_pesanan.id_menu')->where('detail_pesanan.id_pesanan', $id)->get();
        return view('guest.pesanan.success', compact('pesanan', 'details'));
    }

    // public function history()
    // {
    //     // Karena ada pengecekan nama Auth di checkout, kita bisa asumsikan relasi user dengan nama
    //     $namaAkses = Auth::user()->nama ?? 'Guest';
    //     if ($namaAkses === 'Guest') {
    //         // Untuk guest mungkin tidak bisa simpan history yang persisten kecuali pakai session.
    //         // Di sini sekadar mengambil berdasarkan nama guest atau biarkan kosong, sesuai implementasi sebelumnya
    //         $pesanan = Pesanan::where('nama', 'Guest')->orderBy('id_pesanan', 'desc')->get();
    //     } else {
    //         $pesanan = Pesanan::where('nama', $namaAkses)->orderBy('id_pesanan', 'desc')->get();
    //     }
        
    //     return view('guest.pesanan.history', compact('pesanan'));
    // }
}
