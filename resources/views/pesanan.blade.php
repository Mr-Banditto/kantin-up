<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - SIUP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #0047ba; --secondary: #00a1e4; --success: #28a745; }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f8f9fa; color: #333; }
        
        .sidebar { 
            width: 280px; 
            position: fixed; 
            height: 100vh; 
            background: white; 
            border-right: 1px solid #eee; 
            padding: 20px; 
            box-sizing: border-box; 
            display: flex; 
            flex-direction: column; 
        }

        .sidebar-nav { flex-grow: 1; margin-top: 20px; }
        
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 10px; text-decoration: none; color: #555; margin-bottom: 5px; transition: 0.3s; }
        .menu-item:hover, .menu-item.active { background: var(--primary); color: white; }
        .menu-item i { margin-right: 15px; width: 20px; }

        .btn-logout { background: none; border: none; color: #dc3545; cursor: pointer; font-family: inherit; font-weight: 600; padding: 15px 10px; width: 100%; text-align: left; display: flex; align-items: center; gap: 15px; }
        .btn-logout:hover { background-color: #fff5f5; border-radius: 10px; }

        .logo-section { text-align: center; margin-bottom: 30px; }
        .logo-section img { width: 180px; }

        .main-content { margin-left: 280px; padding: 30px; }
        
        .header { margin-bottom: 30px; }
        .header h2 { margin: 0; color: var(--primary); }

        .order-card { background: white; border-radius: 15px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #ddd; }
        .order-pending { border-left-color: #f39c12; }
        .order-completed { border-left-color: #28a745; }
        .order-processing { border-left-color: #3498db; }

        .order-header { display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .order-date { font-size: 13px; color: #777; }
        .order-status { font-weight: 600; text-transform: uppercase; font-size: 12px; padding: 4px 10px; border-radius: 20px; }
        
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-dimasak { background: #d1ecf1; color: #0c5460; }
        .status-selesai { background: #d4edda; color: #155724; }
        
        .order-body h4 { margin: 0 0 5px 0; }
        .order-details { font-size: 14px; color: #555; }
        .order-price { font-weight: 700; color: var(--primary); font-size: 16px; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo-section">
            <img src="https://sso.universitaspertamina.ac.id/images/logo.png" alt="Logo SIUP">
        </div>

        <div class="sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="menu-item"><i class="fa fa-home"></i> Beranda</a>
            <a href="{{ route('user.favorit') }}" class="menu-item"><i class="fa fa-utensils"></i> Kantin Favorit</a>
            <a href="{{ route('user.history') }}" class="menu-item active"><i class="fa fa-history"></i> Riwayat Pesanan</a>
            <a href="{{ route('user.wallet') }}" class="menu-item"><i class="fa fa-wallet"></i> Digital Wallet</a>
        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Riwayat Pesanan Anda</h2>
            <p style="color: #666;">Pantau status makananmu di sini</p>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div style="text-align: center; padding: 50px; color: #888;">
                <i class="fa fa-receipt fa-4x" style="margin-bottom: 20px; opacity: 0.2;"></i>
                <p>Belum ada riwayat pesanan.</p>
                <a href="{{ route('user.dashboard') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Pesan Sekarang</a>
            </div>
        @else
            @foreach($orders as $o)
                @php
                    $statusClass = 'status-menunggu';
                    $borderClass = 'order-pending';
                    if($o->status == 'dimasak' || $o->status == 'siap') { 
                        $statusClass = 'status-dimasak'; 
                        $borderClass = 'order-processing';
                    }
                    if($o->status == 'selesai') { 
                        $statusClass = 'status-selesai'; 
                        $borderClass = 'order-completed';
                    }
                @endphp

                <div class="order-card {{ $borderClass }}">
                    <div class="order-header">
                        <span class="order-date"><i class="fa fa-calendar"></i> {{ $o->created_at->format('d M Y, H:i') }}</span>
                        <span class="order-status {{ $statusClass }}">{{ ucfirst($o->status) }}</span>
                    </div>
                    <div class="order-body">
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <h4>{{ $o->menu_name ?? ($o->menu->nama_makanan ?? 'Menu Terhapus') }}</h4>
                                <div class="order-details">
                                    <i class="fa fa-store" style="font-size: 12px; margin-right: 5px;"></i> {{ $o->vendor->nama_kantin ?? 'Kantin' }} &bull; 
                                    {{ $o->jumlah }} Porsi
                                </div>
                            </div>
                            <div class="order-price">
                                Rp {{ number_format($o->total_harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</body>
</html>
