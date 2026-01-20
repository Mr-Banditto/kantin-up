<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Menu;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KantinController extends Controller
{
    public function vendor()
    {
        $vendors = Vendor::all();
        return view('vendor', compact('vendors'));
    }

    public function menu($id)
    {
        $menus = Menu::where('vendor_id', $id)->get();
        return view('menu', compact('menus'));
    }

    public function pesan(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
            // 'nama_pembeli' => 'required', // Jika perlu
        ]);
        
        $menu = Menu::findOrFail($request->menu_id);
        $totalHarga = $menu->harga * $request->jumlah;
        $user = Auth::user();

        // Cek Saldo
        if ($user->balance < $totalHarga) {
            return back()->with('error', 'Saldo tidak mencukupi. Silakan top up.');
        }

        // Kurangi Saldo
        $user->balance -= $totalHarga;
        $user->save();

        // Generate Nomor Antrean (Simple: A-001)
        $todayOrders = Order::whereDate('created_at', today())->count();
        $nomorAntrean = 'A-' . str_pad($todayOrders + 1, 3, '0', STR_PAD_LEFT);

        $order = Order::create([
            'user_id' => $user->id, 
            'nama_pembeli' => $user->name, 
            'vendor_id' => $menu->vendor_id, 
            'menu_id' => $request->menu_id,
            'menu_name' => $menu->nama_makanan, 
            'jumlah' => $request->jumlah,
            'harga_satuan' => $menu->harga, 
            'total_harga' => $totalHarga,
            'status' => 'menunggu', 
            'nomor_antrean' => $nomorAntrean
        ]);

        // Log Aktivitas: Mahasiswa membeli menu
        ActivityLog::log('buat_pesanan', "Mahasiswa membuat pesanan: {$menu->nama_makanan} (x{$request->jumlah})", $user->id);

        return redirect()->route('user.history')->with('success', 'Pesanan berhasil dibuat! Saldo terpotong Rp ' . number_format($totalHarga));
    }

    public function pesanan()
    {
        // Hanya tampilkan pesanan milik user yang sedang login
        $orders = Order::where('user_id', Auth::id())
                       ->with(['menu', 'vendor'])
                       ->orderBy('created_at', 'desc')
                       ->get();
                       
        return view('pesanan', compact('orders'));
    }
}
