<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class UserController extends Controller
{
    public function index()
    {
        // 1. Ambil data vendor dari DB (jika kosong, buat dummy agar tidak error)
        $vendors = Vendor::all();
        if($vendors->isEmpty()){
            $vendors = [
                (object)['id' => 1, 'nama_kantin' => 'Kantin Biru', 'deskripsi' => 'Ayam Penyet & Bakar', 'foto' => '', 'is_open' => true],
                (object)['id' => 2, 'nama_kantin' => 'D\'Geprek UP', 'deskripsi' => 'Ayam Geprek Pedas', 'foto' => '', 'is_open' => true],
            ];
        }

        // 2. Data Menu Slider
        $menus = [
            (object)['id' => 1, 'nama' => 'Ayam Penyet', 'harga' => 15000, 'toko' => 'Kantin Biru', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 2, 'nama' => 'Ayam Bakar', 'harga' => 17000, 'toko' => 'Kantin Biru', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 3, 'nama' => 'Ayam Geprek Ori', 'harga' => 13000, 'toko' => 'D\'Geprek UP', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 4, 'nama' => 'Geprek Keju', 'harga' => 16000, 'toko' => 'D\'Geprek UP', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 5, 'nama' => 'Soto Ayam', 'harga' => 12000, 'toko' => 'Soto Seger', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 6, 'nama' => 'Soto Daging', 'harga' => 15000, 'toko' => 'Soto Seger', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 7, 'nama' => 'Es Kopi Susu', 'harga' => 10000, 'toko' => 'Kopi Kampus', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 8, 'nama' => 'Roti Bakar', 'harga' => 12000, 'toko' => 'Kopi Kampus', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 9, 'nama' => 'Nasi Goreng', 'harga' => 15000, 'toko' => 'Warung Barokah', 'foto' => 'https://bit.ly/3Z9vG4W'],
            (object)['id' => 10, 'nama' => 'Mie Ayam', 'harga' => 12000, 'toko' => 'Mie Gajah', 'foto' => 'https://bit.ly/3Z9vG4W'],
        ];

        return view('user.dashboard', compact('menus', 'vendors'));
    }

    public function detail($id)
    {
        return "Detail Kantin ID: " . $id;
    }
}