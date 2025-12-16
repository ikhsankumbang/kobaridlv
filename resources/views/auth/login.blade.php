<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Kobarid</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('images/bengkel.png') }}" alt="Kobarid Logo">
            </div>
            
            <h2>Selamat Datang!</h2>
            <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>
            
            @if($errors->any())
            <div style="background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.4); border-radius: 10px; padding: 14px; margin-bottom: 20px;">
                @foreach($errors->all() as $error)
                    <p style="color: #ff6b6b; margin: 0; font-size: 0.9rem;"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nama_pegawai">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Masukkan nama pegawai" value="{{ old('nama_pegawai') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="id_pegawai">ID Pegawai</label>
                    <input type="password" name="id_pegawai" id="id_pegawai" class="form-control" placeholder="Masukkan ID pegawai" required>
                </div>
                
                <button type="submit" class="btn-login">
                    Masuk
                </button>
            </form>
            
            <div class="forgot-link">
                <p style="color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-top: 2rem;">
                    Kobarid Management System &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
