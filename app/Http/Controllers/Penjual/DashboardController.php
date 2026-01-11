<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:penjual']);
    }

    public function index()
    {
        $vendorId = Auth::user()?->vendor_id;
        
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        // Total Menu
        $totalMenu = Menu::where('vendor_id', $vendorId)->count();

        // Total Pesanan
        $totalOrder = Order::where('vendor_id', $vendorId)->count();

        // Breakdown Status Pesanan
        $orderMenunggu = Order::where('vendor_id', $vendorId)->where('status', 'menunggu')->count();
        $orderDimasak = Order::where('vendor_id', $vendorId)->where('status', 'dimasak')->count();
        $orderSiap = Order::where('vendor_id', $vendorId)->where('status', 'siap')->count();
        $orderSelesai = Order::where('vendor_id', $vendorId)->where('status', 'selesai')->count();

        // Total Revenue
        $totalRevenue = Order::where('vendor_id', $vendorId)
                            ->where('status', 'selesai')
                            ->sum('total_harga');

        // Pesanan Terbaru
        $recentOrders = Order::where('vendor_id', $vendorId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Menu Terpopuler (berdasarkan jumlah order) - cukup ambil menu aktif teratas
        $popularMenus = Menu::where('vendor_id', $vendorId)
                           ->where('tersedia', true)
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();

        return view('penjual.index', compact(
            'totalMenu',
            'totalOrder',
            'orderMenunggu',
            'orderDimasak',
            'orderSiap',
            'orderSelesai',
            'totalRevenue',
            'recentOrders',
            'popularMenus'
        ));
    }
}
