<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Perpustakaan' }}</title>
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg-main: #f3f5f9;
            --bg-panel: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --brand: #2563eb;
            --brand-soft: #dbeafe;
            --success-soft: #dcfce7;
            --warn-soft: #fef3c7;
            --danger-soft: #fee2e2;
        }

        body {
            background: radial-gradient(circle at 10% -20%, #dbeafe 0%, #eef2f9 35%, #f3f5f9 100%);
            color: var(--ink);
        }

        .app-shell {
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
            border-right: 1px solid var(--line);
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.25rem 0.2rem 0.95rem;
            border-bottom: 1px solid var(--line);
            margin-bottom: 0.9rem;
        }

        .brand-wrap img {
            width: 34px;
            height: 34px;
            object-fit: contain;
        }

        .brand-wrap h6 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.15px;
        }

        .brand-wrap small {
            color: var(--muted);
        }

        .sidebar-group-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin: 0.9rem 0 0.5rem;
            padding-left: 0.45rem;
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: #334155;
            border-radius: 0.7rem;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.56rem 0.78rem;
            transition: all .2s ease;
        }

        .sidebar .nav-link::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
            margin-right: 0.55rem;
            vertical-align: middle;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #0f172a;
            background: #e2e8f0;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(90deg, var(--brand-soft), #eff6ff);
            color: #1d4ed8;
            box-shadow: inset 0 0 0 1px #bfdbfe;
        }

        .sidebar .nav-link.active::before,
        .sidebar .nav-link:hover::before {
            background: #3b82f6;
        }

        .main-pane {
            padding: 1.05rem 1.05rem 1.2rem;
        }

        .topbar {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: 0.9rem;
            padding: 0.75rem 0.9rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .topbar .search-input {
            border-radius: 0.65rem;
            border-color: var(--line);
            font-size: 0.9rem;
        }

        .topbar .search-input:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .15);
        }

        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 0.28rem 0.5rem 0.28rem 0.3rem;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: #1e3a8a;
            background: #dbeafe;
        }

        .app-card {
            border: 1px solid var(--line);
            border-radius: 0.95rem;
            background: var(--bg-panel);
            box-shadow: 0 10px 25px rgba(2, 6, 23, 0.04);
        }

        .admin-footer {
            border: 1px solid var(--line);
            background: linear-gradient(120deg, #ffffff 0%, #f8fafc 50%, #eef2ff 100%);
            border-radius: 0.9rem;
            color: #475569;
            padding: 0.85rem 1rem;
            font-size: 0.86rem;
            margin-top: 1rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .main-pane {
                padding: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row app-shell">
        <aside class="col-lg-2 col-md-3 sidebar p-3">
            <div class="brand-wrap">
                <img src="{{ asset('template/img/Logo.png') }}" alt="Logo">
                <div>
                    <h6>Perpustakaan</h6>
                    <small>Admin Panel</small>
                </div>
            </div>

            <small class="text-muted d-block mb-2">
                {{ session('staff_user_name', '-') }} ({{ session('staff_user_role', '-') }})
            </small>

            <div class="sidebar-group-title">Menu Utama</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Kategori Buku</a>
                <a class="nav-link {{ request()->routeIs('admin.publishers*') ? 'active' : '' }}" href="{{ route('admin.publishers.index') }}">Penerbit</a>
                <a class="nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}" href="{{ route('admin.books.index') }}">Buku</a>
                <a class="nav-link {{ request()->routeIs('admin.copies*') ? 'active' : '' }}" href="{{ route('admin.copies.index') }}">Eksemplar Buku</a>
            </nav>

            <div class="sidebar-group-title">Transaksi</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.members*') ? 'active' : '' }}" href="{{ route('admin.members.index') }}">Anggota</a>
                <a class="nav-link {{ request()->routeIs('admin.borrowings*') ? 'active' : '' }}" href="{{ route('admin.borrowings.index') }}">Peminjaman</a>
                <a class="nav-link {{ request()->routeIs('admin.returns*') ? 'active' : '' }}" href="{{ route('admin.returns.index') }}">Pengembalian</a>
                <a class="nav-link {{ request()->routeIs('admin.fines*') ? 'active' : '' }}" href="{{ route('admin.fines.index') }}">Denda</a>
            </nav>

            <div class="sidebar-group-title">Konten Website</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.digital-resources*') ? 'active' : '' }}" href="{{ route('admin.digital-resources.index') }}">Artikel & Jurnal</a>
                <a class="nav-link {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">Pengumuman</a>
                <a class="nav-link {{ request()->routeIs('admin.forum*') ? 'active' : '' }}" href="{{ route('admin.forum.index') }}">Forum</a>
                <a class="nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}">Galeri</a>
                <a class="nav-link {{ request()->routeIs('admin.faq*') ? 'active' : '' }}" href="{{ route('admin.faq.index') }}">FAQ</a>
            </nav>

            <div class="sidebar-group-title">Pengaturan</div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">Laporan</a>
                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">Pengaturan</a>
                <a class="nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">Profil Petugas</a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                @csrf
                <button class="btn btn-sm btn-outline-secondary w-100" type="submit">Logout</button>
            </form>
        </aside>

        <main class="col-lg-10 col-md-9 main-pane">
            <div class="topbar d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <strong class="d-block">Admin Dashboard</strong>
                    <small class="text-muted">Monitoring data perpustakaan harian</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" class="form-control search-input" placeholder="Cari menu..." style="width: 180px;">
                    <div class="user-chip">
                        <span class="user-avatar">{{ strtoupper(substr((string) session('staff_user_name', 'A'), 0, 1)) }}</span>
                        <small class="fw-semibold text-muted">{{ session('staff_user_name', '-') }}</small>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Validasi gagal:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            @include('admin.partials.footer')
        </main>
    </div>
</div>
</body>
</html>
