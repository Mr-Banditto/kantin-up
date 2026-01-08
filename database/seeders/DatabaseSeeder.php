<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        User::truncate(); 

        // Buat user dummy
        User::create([
            'name' => 'mahasiswa_up', // Ini yang akan diketik di kolom Username
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'), // Ini passwordnya
            'role' => 'user'
        ]);
        
        // Tambahkan admin untuk tes nanti
        User::create([
            'name' => 'admin_up',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Buat User Penjual (Pastikan baris ini ada!)
        \App\Models\User::create([
        'name' => 'penjual_up',
        'email' => 'penjual@gmail.com',
        'password' => bcrypt('password123'),
        'role' => 'penjual'
        ]);

        $kantins = [
            ['nama' => 'Kantin Biru', 'desc' => 'Spesialis Ayam Penyet & Sambal'],
            ['nama' => 'D’Geprek', 'desc' => 'Ayam Geprek Level Mahasiswa'],
            ['nama' => 'Kantin Sehat', 'desc' => 'Makanan Rumahan & Sayur Segar'],
            ['nama' => 'Kedai Kopi UP', 'desc' => 'Kopi dan Cemilan Tugas'],
        ];

        foreach ($kantins as $k) {
            $vendor = \App\Models\Vendor::create([
                'nama_kantin' => $k['nama'],
                'deskripsi' => $k['desc'],
                'is_open' => true,
            ]);

            // Buat 3 Menu per Kantin
            for ($i = 1; $i <= 3; $i++) {
                \App\Models\Menu::create([
                    'vendor_id' => $vendor->id,
                    'nama_makanan' => $k['nama'] . " Menu " . $i,
                    'harga' => rand(10000, 25000),
                    'deskripsi' => 'Deskripsi lezat untuk menu ini yang sangat menggugah selera.',
                    'tersedia' => true,
              ]);
            }
        }
    }
}