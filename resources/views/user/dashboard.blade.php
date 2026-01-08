<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIUP - Pemesanan Kantin UP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #0047ba; --secondary: #00a1e4; --success: #28a745; }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f8f9fa; color: #333; }
        
        /* Sidebar */
            .sidebar { 
        width: 280px; 
        position: fixed; /* Membuat sidebar tetap diam di tempat */
        height: 100vh; /* Tinggi penuh layar */
        background: white; 
        border-right: 1px solid #eee; 
        padding: 20px; 
        box-sizing: border-box; 
        display: flex; /* Mengaktifkan Flexbox */
        flex-direction: column; /* Menyusun konten dari atas ke bawah */
        z-index: 1000;
    }

    /* Tambahkan ini agar area menu mengambil ruang sisa dan mendorong logout ke bawah */
    .sidebar-nav {
        flex-grow: 1; 
        margin-top: 20px;
    }

    .btn-logout { 
        background: none; 
        border: none; 
        color: #dc3545; 
        cursor: pointer; 
        font-family: inherit; 
        font-weight: 600; 
        padding: 15px 10px;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: 0.3s;
    }

    .btn-logout:hover {
        background-color: #fff5f5;
        border-radius: 10px;
    }
        .logo-section { text-align: center; margin-bottom: 30px; }
        .logo-section img { width: 180px; }
        
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 10px; text-decoration: none; color: #555; margin-bottom: 5px; transition: 0.3s; }
        .menu-item:hover, .menu-item.active { background: var(--primary); color: white; }
        .menu-item i { margin-right: 15px; width: 20px; }

        /* Main Content */
        .main-content { margin-left: 280px; padding: 30px; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-profile { display: flex; align-items: center; gap: 10px; background: white; padding: 8px 15px; border-radius: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* Antrean Banner */
        .queue-banner { background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        
        /* Grid Kantin */
        .section-title { font-weight: 600; margin-bottom: 20px; display: flex; justify-content: space-between; }
        .canteen-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .canteen-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: 0.3s; cursor: pointer; border: 1px solid transparent; }
        .canteen-card:hover { transform: translateY(-5px); border-color: var(--secondary); }
        .canteen-img { height: 160px; background: #ddd; background-size: cover; background-position: center; }
        .canteen-info { padding: 20px; }
        .canteen-info h3 { margin: 0 0 10px 0; font-size: 18px; }
        .badge-open { background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }

        .btn-logout { background: none; border: none; color: #dc3545; cursor: pointer; font-family: inherit; font-weight: 600; }
    
        /* --- Tambahkan ini di dalam <style> --- */
        .menu-slider {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 10px 5px 25px 5px;
            scroll-behavior: smooth;
            scrollbar-width: none; 
        }
        .menu-slider::-webkit-scrollbar { display: none; }

        .menu-card-item {
            flex: 0 0 180px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
            cursor: pointer;
        }
        .menu-card-item:hover { transform: translateY(-5px); }
        .menu-thumb { height: 110px; width: 100%; background-size: cover; background-position: center; }
        .menu-details { padding: 12px; }
        .menu-details h4 { margin: 0; font-size: 14px; color: #333; }
        .menu-details span { font-size: 11px; color: #888; display: block; margin: 3px 0 8px 0; }
        .menu-details .price { color: #0047ba; font-weight: 700; font-size: 14px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-section">
            <img src="https://sso.universitaspertamina.ac.id/images/logo.png" alt="Logo SIUP">
        </div>

        <!-- Gunakan div pembungkus untuk menu navigasi -->
        <div class="sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="menu-item active"><i class="fa fa-home"></i> Beranda</a>
            <a href="{{ route('user.favorit') }}" class="menu-item"><i class="fa fa-utensils"></i> Kantin Favorit</a>
            <a href="{{ route('user.history') }}" class="menu-item"><i class="fa fa-history"></i> Riwayat Pesanan</a>
            <a href="{{ route('user.wallet') }}" class="menu-item"><i class="fa fa-wallet"></i> Digital Wallet</a>
        </div>

        <!-- Bagian Logout akan selalu di paling bawah karena flex-grow di atasnya -->
        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>
        
        <div style="position: absolute; bottom: 30px; width: 220px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fa fa-sign-out-alt"></i> Keluar Sistem</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Kantin Mahasiswa</h2>
            <div class="user-profile" style="gap: 20px;">
                <!-- Bagian Saldo -->
                <div style="text-align: right; border-right: 1px solid #ddd; padding-right: 15px;">
                    <small style="color: #777; display: block; font-size: 10px;">SALDO SIUP PAY</small>
                    <span style="color: #28a745; font-weight: 600;">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                </div>
    
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa fa-circle-user fa-lg"></i>
                    <span>{{ Auth::user()->name }}</span>
                 </div>
            </div>
        </div>

        <!-- Banner Antrean Virtual (Notifikasi Real-time) -->
        <div class="queue-banner">
            <div>
                <h3 style="margin: 0;">Status Pesanan Terakhir</h3>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Anda belum memiliki pesanan aktif saat ini.</p>
            </div>
            <i class="fa fa-clock-rotate-left fa-3x" style="opacity: 0.3;"></i>
        </div>

        <!-- TEMPATKAN DI SINI (Di bawah banner biru status pesanan) -->
        <div class="section-title" style="margin-top: 25px;">
            <h3>Rekomendasi Menu Hari Ini</h3>
            <span style="font-size: 12px; color: #888;">Geser ke samping <i class="fa fa-arrow-right"></i></span>
        </div>

        <div class="menu-slider">
            @foreach($menus as $menu)
            <div class="menu-card-item">
                <div class="menu-thumb" style="background-image: url('{{ $menu->foto }}')"></div>
                <div class="menu-details">
                    <h4>{{ $menu->nama }}</h4>
                    <span><i class="fa fa-store"></i> {{ $menu->toko }}</span>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                        <i class="fa fa-plus-circle" style="color: #0047ba; font-size: 20px;"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- LANJUT KE BAGIAN "DAFTAR KANTIN TERSEDIA" -->

        <div class="section-title">
            <h3>Daftar Kantin Tersedia</h3>
            <span>Lihat Semua <i class="fa fa-chevron-right"></i></span>
        </div>

        <!-- Daftar Kantin -->
        <div class="canteen-grid">
            @foreach($vendors as $v)
            <div class="canteen-card" onclick="location.href='{{ route('user.kantin', $v->id) }}'">
                <div class="canteen-img" style="background-image: url('https://via.placeholder.com/400x200?text={{ $v->nama_kantin }}')"></div>
                <div class="canteen-info">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span class="badge-open">{{ $v->is_open ? 'BUKA' : 'TUTUP' }}</span>
                        <span style="color: #f39c12;"><i class="fa fa-star"></i> 4.{{ rand(5,9) }}</span>
                    </div>
                    <h3>{{ $v->nama_kantin }}</h3>
                    <p style="color: #777; font-size: 14px; margin-bottom: 15px;">{{ $v->deskripsi }}</p>
                    <div style="border-top: 1px solid #eee; padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; color: #555;"><i class="fa fa-clock"></i> 10-15 Menit</span>
                        <!-- Tombol Pesan Sekarang langsung ke halaman menu -->
                        <a href="{{ route('user.kantin', $v->id) }}" class="btn-order-now">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>