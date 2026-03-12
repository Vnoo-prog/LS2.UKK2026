<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/dashboard">PerpusDigital</a>
            <div class="collapse navbar-collapse">
                
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link text-white" href="/dashboard">Dashboard</a></li>
                        @can('kelola-barang')
                            <li class="nav-item"><a class="nav-link text-white" href="/buku">Kelola Buku</a></li>
                            
                            <li class="nav-item"><a class="nav-link text-warning fw-bold" href="/laporan">Laporan</a></li>
                        @endcan
                        
                        @can('meminjam')
                            <li class="nav-item"><a class="nav-link text-white" href="/peminjaman/riwayat">Koleksi & Riwayatku</a></li>
                        @endcan
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-white fw-bold">Halo, {{ Auth::user()->username }} ({{ Auth::user()->role }})</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-danger mt-1 ms-2" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>