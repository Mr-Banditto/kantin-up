<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Wallet - SIUP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #0047ba; --secondary: #00a1e4; --success: #28a745; }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f8f9fa; color: #333; }
        
        .sidebar { 
            width: 280px; position: fixed; height: 100vh; background: white; 
            border-right: 1px solid #eee; padding: 20px; box-sizing: border-box; 
            display: flex; flex-direction: column; 
        }
        .sidebar-nav { flex-grow: 1; margin-top: 20px; }
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 10px; text-decoration: none; color: #555; margin-bottom: 5px; transition: 0.3s; }
        .menu-item:hover, .menu-item.active { background: var(--primary); color: white; }
        .menu-item i { margin-right: 15px; width: 20px; }
        .btn-logout { background: none; border: none; color: #dc3545; cursor: pointer; font-family: inherit; font-weight: 600; padding: 15px 10px; width: 100%; text-align: left; display: flex; align-items: center; gap: 15px; }
        
        .main-content { margin-left: 280px; padding: 30px; }
        
        /* Wallet Card */
        .wallet-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; padding: 30px; border-radius: 20px; margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 71, 186, 0.2); position: relative; overflow: hidden;
        }
        .wallet-card::after {
            content: ''; position: absolute; right: -20px; top: -20px; width: 150px; height: 150px;
            background: rgba(255,255,255,0.1); border-radius: 50%;
        }
        .balance-label { font-size: 14px; opacity: 0.9; }
        .balance-amount { font-size: 36px; font-weight: 700; margin: 10px 0; }
        
        .action-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 30px; }
        .action-btn { background: white; border: none; padding: 15px; border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.2s; }
        .action-btn:hover { transform: translateY(-3px); }
        .action-btn i { color: var(--primary); font-size: 20px; }

        .transaction-list { background: white; border-radius: 15px; padding: 20px; }
        .transaction-item { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding: 15px 0; }
        .transaction-item:last-child { border-bottom: none; }
        .t-icon { width: 40px; height: 40px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: #555; }
        .t-info h4 { margin: 0 0 5px 0; font-size: 14px; }
        .t-info span { font-size: 12px; color: #888; }
        .t-amount { font-weight: 600; }
        .amount-minus { color: #dc3545; }
        .amount-plus { color: #28a745; }

        /* Modal Topup */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; }
        .modal-content { background: white; padding: 25px; border-radius: 15px; width: 90%; max-width: 400px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="https://sso.universitaspertamina.ac.id/images/logo.png" alt="Logo" style="width: 180px;">
        </div>
        <div class="sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="menu-item"><i class="fa fa-home"></i> Beranda</a>
            <a href="{{ route('user.favorit') }}" class="menu-item"><i class="fa fa-utensils"></i> Kantin Favorit</a>
            <a href="{{ route('user.history') }}" class="menu-item"><i class="fa fa-history"></i> Riwayat Pesanan</a>
            <a href="{{ route('user.wallet') }}" class="menu-item active"><i class="fa fa-wallet"></i> Digital Wallet</a>
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
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="wallet-card">
            <div class="balance-label">Saldo Aktif</div>
            <div class="balance-amount">Rp {{ number_format($user->balance, 0, ',', '.') }}</div>
            <p style="margin: 0; font-size: 13px; opacity: 0.8;">{{ $user->name }} • {{ $user->email }}</p>
        </div>

        <div class="action-grid">
            <button class="action-btn" onclick="openTopup()">
                <i class="fa fa-plus-circle"></i> Top Up Saldo
            </button>
            <button class="action-btn">
                <i class="fa fa-exchange-alt"></i> Transfer (Coming Soon)
            </button>
        </div>

        <div class="transaction-list">
            <h3 style="margin-top: 0; margin-bottom: 20px;">Riwayat Transaksi</h3>
            
            @if($expenses->isEmpty())
                <p style="text-align: center; color: #888; padding: 20px;">Belum ada transaksi.</p>
            @else
                @foreach($expenses as $exp)
                <div class="transaction-item">
                    <div style="display: flex; align-items: center;">
                        <div class="t-icon"><i class="fa fa-utensils"></i></div>
                        <div class="t-info">
                            <h4>Pembayaran Makanan</h4>
                            <span>{{ $exp->created_at->format('d M Y, H:i') }} • {{ $exp->menu_name ?? 'Menu' }}</span>
                        </div>
                    </div>
                    <div class="t-amount amount-minus">- Rp {{ number_format($exp->total_harga, 0, ',', '.') }}</div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Modal Top Up -->
    <div id="topupModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-top: 0; text-align: center;">Isi Saldo Wallet</h3>
            
            <div style="text-align: center; margin-bottom: 20px; background: #f8f9fa; padding: 15px; border-radius: 10px;">
                <p style="margin: 0 0 10px 0; font-weight: 600; font-size: 14px;">Scan QRIS</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TopUpSIUP" alt="QRIS Code" style="width: 150px; height: 150px; border: 1px solid #ddd; padding: 5px; background: white;">
                <p style="font-size: 11px; color: #888; margin-top: 5px;">SIUP Digital Payment</p>
            </div>

            <form action="{{ route('user.top-up') }}" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 8px;">Nominal Top Up</label>
                    <select name="amount" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        <option value="10000">Rp 10.000</option>
                        <option value="20000">Rp 20.000</option>
                        <option value="50000">Rp 50.000</option>
                        <option value="100000">Rp 100.000</option>
                        <option value="500000">Rp 500.000</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeTopup()" style="flex: 1; padding: 12px; background: #eee; border: none; border-radius: 8px; cursor: pointer;">Batal</button>
                    <button type="submit" style="flex: 1; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer;">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openTopup() { document.getElementById('topupModal').style.display = 'flex'; }
        function closeTopup() { document.getElementById('topupModal').style.display = 'none'; }
        window.onclick = function(e) { if(e.target == document.getElementById('topupModal')) closeTopup(); }
    </script>
</body>
</html>
