<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Perpustakaan SMA 25</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --ink: #0f172a;
            --muted: #64748b;
            --line: #dbe3ef;
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f8fd;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.14), transparent 25%),
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.14), transparent 22%),
                linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
        }

        .page-wrap {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .back-link {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.2rem;
            color: var(--ink);
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--line);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .register-card {
            width: 100%;
            max-width: 560px;
            border: 1px solid var(--line);
            border-radius: 1.4rem;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
            overflow: hidden;
        }

        .register-card .card-body {
            padding: 2rem;
        }

        .register-title {
            font-size: clamp(1.8rem, 4vw, 2.3rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .register-text {
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .btn-brand {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        .btn-brand:hover {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
            color: #fff;
        }

        @media (max-width: 575.98px) {
            .register-card .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
<div class="page-wrap">
    <a class="back-link" href="{{ route('library.login') }}" aria-label="Kembali">←</a>

    <div class="register-card card">
        <div class="card-body">
            <h1 class="register-title">Buat Akun Baru</h1>
            <p class="register-text">Isi data berikut untuk membuat akun siswa. Username dan password ini nanti dipakai saat login.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('library.register.store') }}" class="row g-3">
                @csrf
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" class="form-control form-control-lg" name="username" value="{{ old('username') }}" placeholder="username tanpa spasi" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control form-control-lg" name="password" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-lg" name="password_confirmation" required>
                </div>
                <div class="col-12 d-grid">
                    <button class="btn btn-brand btn-lg" type="submit">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>