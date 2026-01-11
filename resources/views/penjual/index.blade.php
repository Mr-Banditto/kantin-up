@extends('penjual.dashboard')

@section('content')
    <style>
        .dashboard-header { margin-bottom: 40px; }
        .welcome-text { font-size: 28px; font-weight: 700; color: #0047ba; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #0047ba; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .stat-icon { font-size: 32px; margin-bottom: 15px; }
        .stat-number { font-size: 36px; font-weight: 700; color: #0047ba; margin-bottom: 5px; }
        .stat-label { font-size: 13px; color: #888; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
        .stat-card.menu { border-left-color: #00a1e4; }
        .stat-card.menu .stat-number { color: #00a1e4; }
        .stat-card.menunggu { border-left-color: #f39c12; }
        .stat-card.menunggu .stat-number { color: #f39c12; }
        .stat-card.dimasak { border-left-color: #e67e22; }
        .stat-card.dimasak .stat-number { color: #e67e22; }
        .stat-card.siap { border-left-color: #27ae60; }
        .stat-card.siap .stat-number { color: #27ae60; }
        .stat-card.revenue { border-left-color: #28a745; }
        .stat-card.revenue .stat-number { color: #28a745; }
        .section-title { font-size: 18px; font-weight: 700; color: #0047ba; margin-bottom: 20px; margin-top: 40px; }
        .recent-orders { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; }
        .recent-orders table { width: 100%; border-collapse: collapse; }
        .recent-orders thead { background: linear-gradient(to right, #0047ba, #00a1e4); color: white; }
        .recent-orders th { padding: 16px; text-align: left; font-weight: 600; font-size: 13px; }
        .recent-orders td { padding: 14px 16px; border-bottom: 1px solid #f0f0f0; }
        .recent-orders tbody tr:hover { background: #f8f9fa; }
        .order-no { font-weight: 600; color: #0047ba; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-dimasak { background: #cce5ff; color: #004085; }
        .status-siap { background: #d4edda; color: #155724; }
        .status-selesai { background: #d1ecf1; color: #0c5460; }
        .popular-menus { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .menu-item { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; }
        .menu-name { font-weight: 600; color: #333; margin-bottom: 8px; }
        .menu-count { font-size: 20px; font-weight: 700; color: #0047ba; margin-bottom: 5px; }
        .menu-label { font-size: 12px; color: #888; }
        .empty-state { text-align: center; padding: 40px; color: #999; }
    </style>

    <div class="dashboard-header">
        <div class="welcome-text">
            <i class="fa fa-chart-pie" style="margin-right: 12px;"></i>Dashboard Penjual
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card menu">
            <div class="stat-icon"><i class="fa fa-utensils"></i></div>
            <div class="stat-number">{{ $totalMenu }}</div>
            <div class="stat-label">Total Menu</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fa fa-shopping-basket"></i></div>
            <div class="stat-number">{{ $totalOrder }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>

        <div class="stat-card menunggu">
            <div class="stat-icon"><i class="fa fa-clock"></i></div>
            <div class="stat-number">{{ $orderMenunggu }}</div>
            <div class="stat-label">Menunggu</div>
        </div>

        <div class="stat-card dimasak">
            <div class="stat-icon"><i class="fa fa-fire"></i></div>
            <div class="stat-number">{{ $orderDimasak }}</div>
            <div class="stat-label">Sedang Dimasak</div>
        </div>

        <div class="stat-card siap">
            <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
            <div class="stat-number">{{ $orderSiap }}</div>
            <div class="stat-label">Siap Diambil</div>
        </div>

        <div class="stat-card revenue">
            <div class="stat-icon"><i class="fa fa-money-bill"></i></div>
            <div class="stat-number">{{ number_format($totalRevenue / 1000000, 1) }}M</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <h3 class="section-title"><i class="fa fa-history" style="margin-right: 10px;"></i>Pesanan Terbaru</h3>
    <div class="recent-orders">
        @if($recentOrders->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><span class="order-no">{{ $order->nomor_antrean }}</span></td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fa fa-inbox fa-2x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                <p>Belum ada pesanan</p>
            </div>
        @endif
    </div>

    <!-- Menu Populer -->
    <h3 class="section-title"><i class="fa fa-star" style="margin-right: 10px;"></i>Menu Tersedia</h3>
    <div class="popular-menus">
        @if($popularMenus->count() > 0)
            @foreach($popularMenus as $menu)
                <div class="menu-item">
                    <div class="menu-name">{{ $menu->nama_makanan }}</div>
                    <div style="margin-top: 12px; font-size: 14px; font-weight: 600; color: #28a745;">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </div>
                    <div style="margin-top: 8px; font-size: 12px; color: #888;">
                        @if($menu->tersedia)
                            <span style="display: inline-block; background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px;">
                                Tersedia
                            </span>
                        @else
                            <span style="display: inline-block; background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px;">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div style="grid-column: 1/-1;">
                <div class="empty-state">
                    <i class="fa fa-utensils fa-2x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>Belum ada menu</p>
                </div>
            </div>
        @endif
    </div>
@endsection
