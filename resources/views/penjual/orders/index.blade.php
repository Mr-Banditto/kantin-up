@extends('penjual.dashboard')

@section('content')
    <style>
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .order-table { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; }
        .order-table table { width: 100%; border-collapse: collapse; }
        .order-table thead { background: linear-gradient(to right, #0047ba, #00a1e4); color: white; }
        .order-table th { padding: 16px; text-align: left; font-weight: 600; font-size: 13px; text-transform: uppercase; }
        .order-table td { padding: 16px; border-bottom: 1px solid #f0f0f0; }
        .order-table tbody tr:hover { background: #f8f9fa; }
        .order-row { display: flex; justify-content: space-between; align-items: center; }
        .order-nomor { font-weight: 600; color: #0047ba; font-size: 15px; }
        .order-user { color: #333; font-weight: 500; }
        .order-user small { display: block; color: #888; font-size: 12px; }
        .status-badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-dimasak { background: #cce5ff; color: #004085; }
        .status-siap { background: #d4edda; color: #155724; }
        .status-selesai { background: #d1ecf1; color: #0c5460; }
        .status-dibatalkan { background: #f8d7da; color: #721c24; }
        .status-dropdown { padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px; cursor: pointer; }
        .action-btn { padding: 8px 16px; background: #f5f5f5; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 12px; transition: 0.3s; }
        .action-btn:hover { background: #0047ba; color: white; }
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state-icon { font-size: 48px; color: #ccc; margin-bottom: 15px; }
        .empty-state-text { color: #999; font-size: 16px; }
        .success-msg { background: #d4edda; border-left: 4px solid #28a745; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; }
        .filter-bar { display: flex; gap: 12px; margin-bottom: 20px; }
        .filter-btn { padding: 10px 16px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; transition: 0.3s; }
        .filter-btn.active { background: #0047ba; color: white; border-color: #0047ba; }
        .price-highlight { font-weight: 600; color: #28a745; }
        @media (max-width: 768px) {
            .order-table table { font-size: 12px; }
            .order-table th, .order-table td { padding: 12px; }
        }
    </style>

    <div class="page-header">
        <h2 style="margin:0; color:#0047ba"><i class="fa fa-inbox" style="margin-right:10px"></i>Pesanan Masuk</h2>
    </div>

    @if(session('success'))
        <div class="success-msg">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="order-table">
        @forelse($orders ?? [] as $order)
            @if($loop->first)
                <table>
                    <thead>
                        <tr>
                            <th>No. Antrean</th>
                            <th>Pembeli</th>
                            <th>Total Harga</th>
                            <th>Estimasi (menit)</th>
                            <th>Status Saat Ini</th>
                            <th>Ubah Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
            @endif
                        <tr>
                            <td><span class="order-nomor">{{ $order->nomor_antrean }}</span></td>
                            <td>
                                <span class="order-user">
                                    {{ $order->user->name ?? 'Guest' }}
                                    <small>{{ $order->created_at->format('d M Y H:i') }}</small>
                                </span>
                            </td>
                            <td><span class="price-highlight">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></td>
                            <td><strong>{{ $order->estimasi_menit }} menit</strong></td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    <i class="fa {{ match($order->status) {
                                        'menunggu' => 'fa-clock',
                                        'dimasak' => 'fa-fire',
                                        'siap' => 'fa-check-circle',
                                        'selesai' => 'fa-thumbs-up',
                                        'dibatalkan' => 'fa-ban',
                                        default => 'fa-info-circle'
                                    } }}"></i>
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('penjual.orders.updateStatus', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                        <option value="">Pilih Status</option>
                                        <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="dimasak" {{ $order->status == 'dimasak' ? 'selected' : '' }}>Sedang Dimasak</option>
                                        <option value="siap" {{ $order->status == 'siap' ? 'selected' : '' }}>Siap Diambil</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('penjual.orders.show', $order->id) }}" class="action-btn">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
            @if($loop->last)
                    </tbody>
                </table>
            @endif
        @empty
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fa fa-inbox"></i></div>
                <div class="empty-state-text">Belum ada pesanan yang masuk</div>
            </div>
        @endforelse
    </div>

    @if(method_exists($orders ?? null, 'links'))
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
