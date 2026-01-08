<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SIUP Kantin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e0e0e0; 
            background-image: radial-gradient(#d1d1d1 1px, transparent 1px); 
            background-size: 20px 20px;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }
        .card { 
            background: white; 
            width: 400px; 
            padding: 40px; 
            border-radius: 4px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            text-align: center; 
            border: 1px solid #ccc;
        }
        .logo { width: 180px; margin-bottom: 25px; }
        .title { font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #333; }
        .desc { font-size: 12px; color: #666; margin-bottom: 25px; line-height: 1.6; padding: 0 10px; }
        
        .input-group { position: relative; margin-bottom: 20px; text-align: left; }
        .input-group i { 
            position: absolute; 
            left: 15px; 
            top: 12px; 
            color: #888; 
            border-right: 1px solid #ddd; 
            padding-right: 10px; 
        }
        .input-group input { 
            width: 100%; 
            padding: 12px 12px 12px 50px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            outline: none; 
            font-size: 14px;
        }
        .input-group input:focus { border-color: #0047ba; }

        .btn-reset { 
            width: 100%; 
            padding: 12px; 
            background: #0047ba; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-reset:hover { background: #00358a; }
        
        .back-link { 
            display: block; 
            margin-top: 25px; 
            font-size: 11px; 
            color: #777; 
            text-decoration: none; 
            font-weight: 600; 
            letter-spacing: 0.5px;
        }
        .back-link:hover { color: #0047ba; }

        /* Alert Styling */
        .alert { 
            padding: 12px; 
            border-radius: 4px; 
            margin-bottom: 20px; 
            font-size: 12px; 
            text-align: center;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="card">
        <!-- Mengambil Logo yang sama dengan login -->
        <img src="https://sso.universitaspertamina.ac.id/images/logo.png" class="logo" alt="Logo Universitas Pertamina">
        
        <div class="title">Lupa Password?</div>
        <div class="desc">Jangan khawatir. Masukkan email SIUP Anda di bawah ini dan kami akan mengirimkan instruksi pemulihan.</div>

        <!-- Notifikasi jika email berhasil dikirim -->
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Notifikasi jika email tidak ditemukan -->
        @if ($errors->has('email'))
            <div class="alert alert-error">
                <i class="fa fa-exclamation-circle"></i> {{ $errors->first('email') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Mahasiswa / Staff" required autofocus>
            </div>
            <button type="submit" class="btn-reset">KIRIM LINK PEMULIHAN</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">KEMBALI KE HALAMAN LOGIN</a>
    </div>
</body>
</html>