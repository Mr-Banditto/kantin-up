@extends('penjual.dashboard')

@section('content')
    <style>
        .detail-header { margin-bottom: 30px; }
        .detail-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
        .detail-image { height: 300px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .detail-image img { max-width: 100%; max-height: 100%; object-fit: cover; width: 100%; height: 100%; }
        .detail-body { padding: 40px; }
        .detail-title { font-size: 28px; font-weight: 700; color: #0047ba; margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f0f0f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #888; font-weight: 600; font-size: 12px; text-transform: uppercase; }
        .detail-value { font-size: 18px; font-weight: 600; color: #333; margin-top: 6px; }
        .price-box { background: linear-gradient(to right, #28a745, #20c997); color: white; padding: 20px; border-radius: 8px; margin: 16px 0; text-align: center; }
        .price-label { font-size: 12px; opacity: 0.9; }
        .price-value { font-size: 28px; font-weight: 700; margin-top: 5px; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-available { background: #d4edda; color: #155724; }
        .status-unavailable { background: #f8d7da; color: #721c24; }
        .description-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0047ba; }
        .btn-group { display: flex; gap: 12px; margin-top: 30px; }
        .btn-action { flex: 1; padding: 14px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; transition: 0.3s; text-decoration: none; text-align: center; }
        .btn-edit { background: linear-gradient(to right, #ffc107, #ff9800); color: white; }
        .btn-edit:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,152,0,0.3); }
        .btn-back { background: #f5f5f5; color: #666; }
        .btn-back:hover { background: #e8e8e8; }
        @media (max-width: 768px) {
            .detail-card { grid-template-columns: 1fr; }
            .detail-image { height: 250px; }
        }
    </style>

    <div class="detail-header">
        <a href="{{ url('/penjual/menus') }}" style="color:#0047ba; text-decoration:none; font-weight:600; display:flex; align-items:center; gap:8px">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Menu
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-image">
            @if(!empty($menu->foto))
                <img src="{{ asset('storage/'.$menu->foto) }}" alt="{{ $menu->nama_makanan }}">
            @else
                <i class="fa fa-utensils" style="font-size:80px; color:white; opacity:0.4"></i>
            @endif
        </div>
        <div class="detail-body">
            <h1 class="detail-title">{{ $menu->nama_makanan }}</h1>

            <div class="price-box">
                <div class="price-label">Harga Menu</div>
                <div class="price-value">Rp {{ isset($menu->harga) ? number_format($menu->harga,0,',','.') : '-' }}</div>
            </div>

            <div class="detail-row">
                <div>
                    <div class="detail-label">Vendor</div>
                    <div class="detail-value">{{ $menu->vendor?->nama_kantin ?? '-' }}</div>
                </div>
                <div style="text-align:right">
                    <div class="detail-label">Status</div>
                    <span class="status-badge {{ !empty($menu->tersedia) ? 'status-available' : 'status-unavailable' }}">
                        <i class="fa {{ !empty($menu->tersedia) ? 'fa-check-circle' : 'fa-ban' }}"></i>
                        {{ !empty($menu->tersedia) ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
            </div>

            @if($menu->deskripsi)
                <div class="description-box">
                    <strong style="color:#0047ba"><i class="fa fa-info-circle"></i> Deskripsi</strong>
                    <p style="margin:12px 0 0 0; color:#555; line-height:1.6">{{ $menu->deskripsi }}</p>
                </div>
            @endif

            <div class="btn-group">
                <a href="{{ url('/penjual/menus/'.$menu->id.'/edit') }}" class="btn-action btn-edit">
                    <i class="fa fa-edit"></i> Edit Menu
                </a>
                <a href="{{ url('/penjual/menus') }}" class="btn-action btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
