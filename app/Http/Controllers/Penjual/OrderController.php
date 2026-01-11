<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:penjual']);
    }

    protected function vendorId()
    {
        $user = Auth::user();
        return $user?->vendor_id;
    }

    // Tampilkan semua pesanan untuk vendor ini
    public function index()
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        // Ambil semua order untuk vendor ini, diurutkan dari terbaru
        $orders = Order::where('vendor_id', $vendorId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        return view('penjual.orders.index', compact('orders'));
    }

    // Tampilkan detail pesanan
    public function show($id)
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        $order = Order::find($id);
        
        if (!$order || $order->vendor_id !== $vendorId) {
            abort(403, 'Anda tidak berhak mengakses pesanan ini');
        }

        return view('penjual.orders.show', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        $order = Order::find($id);
        
        if (!$order || $order->vendor_id !== $vendorId) {
            abort(403, 'Anda tidak berhak mengubah status pesanan ini');
        }

        $request->validate([
            'status' => 'required|in:menunggu,dimasak,siap,selesai,dibatalkan'
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . ucfirst($request->status));
    }
}
