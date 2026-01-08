<!-- Bagian Daftar Kantin -->
<div class="canteen-grid">
    @foreach($vendors as $kantin)
    <div class="canteen-card" onclick="location.href='{{ route('kantin.detail', $kantin->id) }}'">
        <div class="canteen-img" style="background-image: url('{{ asset('img/'.$kantin->foto) }}')"></div>
        <div class="canteen-info">
            <div style="display: flex; justify-content: space-between;">
                <span class="badge-open">{{ $kantin->is_open ? 'BUKA' : 'TUTUP' }}</span>
                <span><i class="fa fa-star" style="color: #f39c12;"></i> 4.5</span>
            </div>
            <h3>{{ $kantin->nama_kantin }}</h3>
            <p>{{ $kantin->deskripsi }}</p>
            
            <div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px;"><i class="fa fa-clock"></i> 15 Min</span>
                
                <!-- Berhenti propagasi agar klik tombol tidak memicu klik kartu (detail) -->
                <a href="{{ route('kantin.order', $kantin->id) }}" 
                   onclick="event.stopPropagation();" 
                   class="btn-pesan">
                   PESAN SEKARANG
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .btn-pesan {
        background: var(--primary);
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
    }
    .btn-pesan:hover { background: var(--secondary); }
</style>