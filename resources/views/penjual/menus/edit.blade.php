@extends('penjual.dashboard')

@section('content')
    <style>
        .form-section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 24px; }
        .form-label { font-weight: 600; color: #333; margin-bottom: 8px; display: block; font-size: 14px; }
        .form-control, .form-textarea { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        .form-control:focus, .form-textarea:focus { outline: none; border-color: #0047ba; box-shadow: 0 0 0 3px rgba(0,71,186,0.1); }
        .form-textarea { resize: vertical; min-height: 100px; }
        .file-input-wrapper { position: relative; }
        .file-input-label { display: inline-block; padding: 12px 20px; background: #f5f5f5; border: 2px dashed #ddd; border-radius: 8px; cursor: pointer; transition: 0.3s; width: 100%; text-align: center; color: #666; }
        .file-input-label:hover { background: #f0f0f0; border-color: #0047ba; color: #0047ba; }
        .file-input-wrapper input[type=file] { display: none; }
        .checkbox-wrapper { display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; }
        .checkbox-wrapper input { margin: 0; }
        .checkbox-wrapper label { margin: 0; cursor: pointer; font-weight: 500; }
        .btn-group { display: flex; gap: 12px; margin-top: 30px; }
        .btn-submit { flex: 1; padding: 14px; background: linear-gradient(to right, #0047ba, #00a1e4); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; transition: 0.3s; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,71,186,0.3); }
        .btn-cancel { flex: 1; padding: 14px; background: #f5f5f5; color: #666; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; transition: 0.3s; text-decoration: none; text-align: center; }
        .btn-cancel:hover { background: #e8e8e8; }
        .error-box { background: #ffe6e6; border-left: 4px solid #c0392b; color: #c0392b; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .error-box ul { margin: 0; padding-left: 20px; }
        .error-box li { margin: 5px 0; }
        .page-title { color: #0047ba; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; }
        .photo-preview { max-width: 200px; border-radius: 8px; margin-top: 15px; border: 1px solid #ddd; padding: 8px; }
    </style>

    <h2 class="page-title"><i class="fa fa-edit"></i>Edit Menu</h2>

    @if($errors->any())
        <div class="error-box">
            <strong><i class="fa fa-exclamation-circle"></i> Ada kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-section">
        <form action="{{ url('/penjual/menus/'.$menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Vendor ditentukan dari akun penjual yang login --}}
            <input type="hidden" name="vendor_id" value="{{ Auth::user()->vendor_id }}">
            @if(!Auth::user()->vendor_id)
                <div style="background:#fff3cd; border-left:4px solid #ffc107; color:#856404; padding:15px; border-radius:8px; margin-bottom:20px">
                    <i class="fa fa-warning"></i> Akun Anda belum terhubung dengan vendor, hubungi admin.
                </div>
            @endif

            <div class="form-group">
                <label class="form-label"><i class="fa fa-utensils" style="margin-right:8px; color:#0047ba"></i>Nama Makanan</label>
                <input type="text" name="nama_makanan" class="form-control" value="{{ $menu->nama_makanan ?? '' }}" required>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa fa-tag" style="margin-right:8px; color:#28a745"></i>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" value="{{ $menu->harga ?? '' }}" required>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa fa-comment" style="margin-right:8px; color:#6f42c1"></i>Deskripsi</label>
                <textarea name="deskripsi" class="form-textarea">{{ $menu->deskripsi ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fa fa-image" style="margin-right:8px; color:#e67e22"></i>Foto Menu (Opsional)</label>
                @if(!empty($menu->foto))
                    <div style="margin-bottom:12px">
                        <img src="{{ asset('storage/'.$menu->foto) }}" alt="foto" class="photo-preview">
                    </div>
                @endif
                <div class="file-input-wrapper">
                    <label class="file-input-label" for="foto">
                        <i class="fa fa-cloud-upload-alt"></i> Klik untuk ganti foto
                    </label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="tersedia" name="tersedia" value="1" {{ !empty($menu->tersedia) ? 'checked' : '' }}>
                    <label for="tersedia"><i class="fa fa-check-circle" style="color:#28a745"></i> Menu ini tersedia</label>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit"><i class="fa fa-save"></i> Simpan Perubahan</button>
                <a href="{{ url('/penjual/menus') }}" class="btn-cancel"><i class="fa fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
@endsection
