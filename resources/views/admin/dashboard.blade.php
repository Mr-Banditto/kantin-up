<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SIUP Kantin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #0b132b; --secondary: #1c2541; --highlight: #3a506b; }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f4f7f6; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 280px; position: fixed; height: 100vh; background: var(--primary); color: white; padding: 20px; box-sizing: border-box; display: flex; flex-direction: column; }
        .logo-section { text-align: center; margin-bottom: 30px; background: white; padding: 10px; border-radius: 10px; }
        .logo-section img { width: 140px; }
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 10px; text-decoration: none; color: #a0aec0; margin-bottom: 5px; transition: 0.3s; }
        .menu-item:hover, .menu-item.active { background: var(--highlight); color: white; }
        .menu-item i { margin-right: 15px; width: 20px; }

        /* Main Content */
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 15px; }

        /* Admin Grid Stats */
        .admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px; }
        .admin-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px; }
        .icon-box { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        
        .bg-user { background: #e0f2fe; color: #0369a1; }
        .bg-vendor { background: #dcfce7; color: #15803d; }
        .bg-trans { background: #fef3c7; color: #b45309; }

        .btn-logout { background: none; border: none; color: #ff4d4d; cursor: pointer; font-weight: 600; margin-top: auto; padding: 10px; text-align: left; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-section"><img src="https://sso.universitaspertamina.ac.id/images/logo.png" alt="Logo"></div>
        <a href="#" class="menu-item active"><i class="fa fa-chart-line"></i> Ringkasan Sistem</a>
        <a href="#" class="menu-item"><i class="fa fa-users"></i> Kelola Mahasiswa</a>
        <a href="#" class="menu-item"><i class="fa fa-store"></i> Kelola Vendor</a>
        <a href="#" class="menu-item"><i class="fa fa-file-invoice-dollar"></i> Laporan Transaksi</a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fa fa-power-off"></i> Shutdown Session</button>
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <h2 style="margin:0">Administrator Control Center</h2>
            <span>Status Server: <strong style="color:green">Online</strong></span>
        </div>

        <div class="admin-grid">
            <div class="admin-card">
                <div class="icon-box bg-user"><i class="fa fa-user-graduate"></i></div>
                <div>
                    <p style="margin:0; color:#888; font-size:12px">TOTAL MAHASISWA</p>
                    <h2 style="margin:0">1,240</h2>
                </div>
            </div>
            <div class="admin-card">
                <div class="icon-box bg-vendor"><i class="fa fa-store"></i></div>
                <div>
                    <p style="margin:0; color:#888; font-size:12px">VENDOR AKTIF</p>
                    <h2 style="margin:0">24</h2>
                </div>
            </div>
            <div class="admin-card">
                <div class="icon-box bg-trans"><i class="fa fa-receipt"></i></div>
                <div>
                    <p style="margin:0; color:#888; font-size:12px">TRANSAKSI HARI INI</p>
                    <h2 style="margin:0">342</h2>
                </div>
            </div>
        </div>

        <div style="margin-top: 40px; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <h4 style="margin-top:0">Log Aktivitas Terbaru</h4>
            <p style="color:#888; font-size:14px">Di sini nanti admin bisa memantau siapa yang login atau kantin mana yang baru saja memperbarui menu makanan.</p>
        </div>
    </div>
</body>
</html>