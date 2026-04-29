<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengguna - Perpustakaan SMA 25</title>
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

        .login-page {
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

        .login-shell {
            width: 100%;
            max-width: 600px;
        }

        .brand-stack {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.15;
        }

        .brand-sub {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 0.15rem;
        }

        .login-card {
            border: 1px solid var(--line);
            border-radius: 1.4rem;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
            overflow: hidden;
        }

        .login-card .card-body {
            padding: 2rem;
        }

        .login-title {
            font-size: clamp(1.8rem, 4vw, 2.3rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .login-text {
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .role-toggle {
            background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
            border: 1px solid var(--line);
            border-radius: 1rem;
            padding: 0.85rem;
            margin-bottom: 1rem;
        }

        .role-toggle .btn {
            border-radius: 999px;
            font-weight: 700;
        }

        .role-toggle .btn.active {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        .role-panel {
            display: none;
            border: 1px solid var(--line);
            border-radius: 1rem;
            padding: 1.1rem;
            background: #fff;
        }

        .role-panel.active {
            display: block;
        }

        .role-panel-title {
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
        }

        .role-card {
            border: 1px solid var(--line);
            border-radius: 1rem;
            padding: 1rem;
            background: #fdfefe;
            height: 100%;
        }

        .helper-box {
            margin-top: 1rem;
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: #f8fbff;
            padding: 1rem;
            color: var(--muted);
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
            .login-card .card-body {
                padding: 1.25rem;
            }

            .brand-stack {
                flex-direction: column;
                text-align: center;
                gap: 0.6rem;
            }
        }
    </style>
</head>
<body>
<div class="login-page">
    <a class="back-link" href="{{ url()->previous() }}" aria-label="Kembali">←</a>
    <div class="login-shell">
        <div class="brand-stack">
            <img class="brand-logo" src="{{ asset('template/img/Logo.png') }}" alt="Logo Perpustakaan">
            <div>
                <div class="brand-name">Perpustakaan</div>
                <div class="brand-sub">SMA Muhammadiyah 25</div>
            </div>
        </div>

        <div class="card login-card">
            <div class="card-body">
                <h1 class="login-title">Masuk ke Akun Anda</h1>
                <p class="login-text">Login siswa memakai username dan password. Admin masuk lewat halaman admin.</p>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-grid mb-3">
                    <button class="btn btn-brand btn-lg" type="button" id="roleToggleBtn">Login Sebagai</button>
                </div>

                <div class="role-toggle d-none" id="roleToggleBox">
                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="button" class="btn btn-outline-primary flex-fill role-tab active" data-role="siswa">Siswa</button>
                        <button type="button" class="btn btn-outline-primary flex-fill role-tab" data-role="admin">Admin</button>
                    </div>
                </div>

                <div class="role-panel active" data-role-panel="siswa">
                    <div class="role-panel-title">Login Siswa</div>
                    <form method="POST" action="{{ route('library.login.attempt') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label fw-semibold">Username</label>
                            <input class="form-control form-control-lg" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Password</label>
                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Masukkan password" required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-brand btn-lg w-100" type="submit">Masuk Siswa</button>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('library.register') }}" class="btn btn-link text-decoration-none fw-semibold">Sign up</a>
                        </div>
                    </form>
                </div>

                <div class="role-panel" data-role-panel="admin">
                    <div class="role-panel-title">Login Admin</div>
                    <div class="role-card mb-3">
                        <p class="mb-0 text-secondary">Masuk ke halaman login admin untuk akses penuh pengelolaan sistem.</p>
                    </div>
                    <a class="btn btn-brand btn-lg w-100" href="{{ route('admin.login', ['role' => 'admin']) }}">Lanjut ke Admin</a>
                </div>

                <div class="helper-box">
                    Setelah login, siswa akan diarahkan ke katalog, sedangkan admin masuk ke halaman login admin.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const roleToggleBtn = document.getElementById('roleToggleBtn');
    const roleToggleBox = document.getElementById('roleToggleBox');
    const roleTabs = document.querySelectorAll('.role-tab');
    const rolePanels = document.querySelectorAll('.role-panel');

    roleToggleBtn?.addEventListener('click', () => {
        roleToggleBox?.classList.toggle('d-none');
    });

    roleTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const role = tab.dataset.role;

            roleTabs.forEach((item) => item.classList.toggle('active', item === tab));
            rolePanels.forEach((panel) => {
                panel.classList.toggle('active', panel.dataset.rolePanel === role);
            });
        });
    });
</script>
</body>
</html>