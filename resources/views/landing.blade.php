<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAMS - Tools Assets Management System</title>
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('icon-reka.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .landing-container {
            width: 100%;
        }

        .header-section {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .header-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .header-section p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .action-card .icon {
            font-size: 5rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .action-card.peminjaman .icon {
            color: #28a745;
        }

        .action-card.pengembalian .icon {
            color: #ffc107;
        }

        .action-card h3 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .action-card p {
            color: #666;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .action-card .btn {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-peminjaman {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }

        .btn-peminjaman:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            color: white;
        }

        .btn-pengembalian {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border: none;
            color: white;
        }

        .btn-pengembalian:hover {
            background: linear-gradient(135deg, #ff9800 0%, #ffc107 100%);
            color: white;
        }

        .admin-link {
            text-align: center;
            margin-top: 40px;
        }

        .admin-link a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .admin-link a:hover {
            opacity: 1;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show fixed-top" style="z-index: 1050; top: 12px; left: 50%; transform: translateX(-50%); max-width: 600px;">
                    <div class="container">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show fixed-top" style="z-index: 1050; top: 12px; left: 50%; transform: translateX(-50%); max-width: 600px;">
                    <div class="container">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Header -->
            <div class="header-section">
                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('img/logo-black.png') }}" alt="REKAINDO GLOBAL JASA" style="height: 80px; margin-bottom: 20px;">
                </a>
                <h1> TAMS </h1>
                <p>Tools Assets Management System</p>
            </div>

            <!-- Action Cards -->
            <div class="row g-4 justify-content-center">
                <!-- Card Peminjaman -->
                <div class="col-md-5">
                    <div class="action-card peminjaman">
                        <div class="icon">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <h3>Form Peminjaman</h3>
                        <p>Ajukan peminjaman alat dengan mengisi formulir peminjaman</p>
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-peminjaman">
                            <i class="bi bi-arrow-right-circle"></i> Pinjam Alat
                        </a>
                    </div>
                </div>

                <!-- Card Pengembalian -->
                <div class="col-md-5">
                    <div class="action-card pengembalian">
                        <div class="icon">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <h3>Form Pengembalian</h3>
                        <p>Kembalikan alat yang telah dipinjam dengan mengisi formulir pengembalian</p>
                        <a href="{{ route('pengembalian.cari') }}" class="btn btn-pengembalian">
                            <i class="bi bi-arrow-left-circle"></i> Kembalikan Alat
                        </a>
                    </div>
                </div>
            </div>

            {{-- <!-- Admin Link -->
            <div class="admin-link">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-gear-fill"></i> Akses Dashboard Admin
                </a>
            </div> --}}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
