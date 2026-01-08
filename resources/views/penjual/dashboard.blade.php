<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard - SIUP Kantin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Mengubah variabel warna ke Biru Pertamina agar konstan */
        :root { 
            --primary: #0047ba; 
            --secondary: #00a1e4; 
            --accent: #3182ce; 
        }
        
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f8f9fa; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 280px; position: fixed; height: 100vh; background: white; border-right: 1px solid #eee; padding: 20px; box-sizing: border-box; display: flex; flex-direction: column; }
        .logo-section { text-align: center; margin-bottom: 30px; }
        .logo-section img { width: 150px; }
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 10px; text-decoration: none; color: #555; margin-bottom: 5px; transition: 0.3s; font-size: 14px; }
        .menu-item:hover, .menu-item.active { background: var(--primary); color: white; }
        .menu-item i { margin-right: 15px; width: 20px; }

        /* Main Content */
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .top-info { display: flex; gap: 15px; align-items: center; }
        .wallet-badge { background: white; padding: 5px 15px; border-radius: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid #eee; text-align: right; }

        /* Banner Status - Sekarang Biru */
        .status-banner { background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; position: relative; overflow: hidden; }
        .status-banner i.bg-icon { position: absolute; right: -20px; bottom: -20px; font-size: 120px; opacity: 0.1; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); text-align: center; border-bottom: 3px solid transparent; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); border-bottom-color: var(--accent); }
        .stat-card h2 { margin: 10px 0 5px 0; font-size: 24px; color: var(--primary); }
        .stat-card p { margin: 0; font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }

        .btn-logout { background: none; border: none; color: #dc3545; cursor: pointer; font-weight: 600; margin-top: auto; padding: 10px; text-align: left; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-section">
            <img src="https://sso.universitaspertamina.ac.id/images/logo.png" alt="Logo Universitas Pertamina">
        </div>
        <a href="#" class="menu-item active"><i class="fa fa-th-large"></i> Dashboard</a>
        <a href="#" class="menu-item"><i class="fa fa-utensils"></i> Kelola Menu</a>
        <a href="#" class="menu-item"><i class="fa fa-shopping-basket"></i> Pesanan Masuk</a>
        <a href="#" class="menu-item"><i class="fa fa-wallet"></i> Saldo Lapak</a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fa fa-sign-out-alt"></i> Keluar Sistem</button>
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="margin:0">Panel Penjual: <strong>{{ Auth::user()->name }}</strong></h2>
            <div class="top-info">
                <div class="wallet-badge">
                    <small style="color:#888; font-size:10px; display:block">PENDAPATAN HARI INI</small>
                    <span style="color:#28a745; font-weight:600">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                </div>
                <div class="wallet-badge" style="display:flex; align-items:center; gap:10px">
                    <i class="fa fa-user-circle fa-lg"></i> <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>
        </div>

        <div class="status-banner">
            <h3 style="margin:0">Toko Anda Sedang <span style="background:#fff; color:var(--primary); padding:2px 10px; border-radius:5px">BUKA</span></h3>
            <p style="margin:10px 0 0 0">Ada 3 pesanan baru yang perlu Anda proses sekarang.</p>
            <i class="fa fa-store bg-icon"></i>
        </div>

        <h3 style="margin-bottom:20px">Ringkasan Peforma</h3>
        <div class="stats-grid">
            <!-- Menunggu -->
            <div class="stat-card">
                <i class="fa fa-clock-rotate-left fa-2x" style="color:#f39c12"></i>
                <h2>3</h2>
                <p>Menunggu</p>
            </div>
            
            <!-- Sedang Dimasak -->
            <div class="stat-card">
                <i class="fa fa-fire fa-2x" style="color:#e67e22"></i>
                <h2>2</h2>
                <p>Sedang Dimasak</p>
            </div>
            
            <!-- Selesai Hari Ini -->
            <div class="stat-card">
                <i class="fa fa-check-double fa-2x" style="color:#27ae60"></i>
                <h2>45</h2>
                <p>Selesai Hari Ini</p>
            </div>
            
            <!-- Menu Aktif (Ikon diganti ke fa-utensils agar pasti muncul) -->
            <div class="stat-card">
                <i class="fa fa-utensils fa-2x" style="color:#0047ba"></i>
                <h2>12</h2>
                <p>Menu Aktif</p>
            </div>
        </div>