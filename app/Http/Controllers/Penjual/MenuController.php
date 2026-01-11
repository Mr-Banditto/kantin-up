<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
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

    public function index()
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        $menus = Menu::where('vendor_id', $vendorId)->paginate(15);
        return view('penjual.menus.index', compact('menus'));
    }

    public function create()
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        return view('penjual.menus.create');
    }

    public function store(Request $request)
    {
        $vendorId = $this->vendorId();
        if (!$vendorId) {
            return back()->withErrors(['vendor' => 'Akun penjual belum terhubung dengan vendor.']);
        }

        $data = $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tersedia' => 'sometimes|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        $data['tersedia'] = $request->has('tersedia') ? 1 : 0;
        $data['vendor_id'] = $vendorId;

        Menu::create($data);
        return redirect('/penjual/menus')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(Menu $menu)
    {
        $vendorId = $this->vendorId();
        if ($menu->vendor_id !== $vendorId) abort(403);
        return view('penjual.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $vendorId = $this->vendorId();
        if ($menu->vendor_id !== $vendorId) abort(403);
        return view('penjual.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $vendorId = $this->vendorId();
        if ($menu->vendor_id !== $vendorId) abort(403);

        $data = $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tersedia' => 'sometimes|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        $data['tersedia'] = $request->has('tersedia') ? 1 : 0;

        $menu->update($data);
        return redirect('/penjual/menus')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $vendorId = $this->vendorId();
        if ($menu->vendor_id !== $vendorId) abort(403);

        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }
        $menu->delete();
        return redirect('/penjual/menus')->with('success', 'Menu berhasil dihapus.');
    }
}
