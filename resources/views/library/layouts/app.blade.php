<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Perpustakaan SMA Muhammadiyah 25')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --ink: #0f172a;
            --soft-ink: #334155;
            --paper: #f8f6f1;
            --teal: #0f766e;
            --teal-dark: #115e59;
            --gold: #f59e0b;
            --sand: #f1ede4;
            --danger: #9f1239;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 20%, rgba(245, 158, 11, 0.15), transparent 30%),
                radial-gradient(circle at 85% 10%, rgba(15, 118, 110, 0.2), transparent 35%),
                linear-gradient(180deg, #f4efe4 0%, #f8f6f1 38%, #ffffff 100%);
            min-height: 100vh;
        }

        h1, h2, h3, h4 {
            font-family: 'Cormorant Garamond', serif;
            letter-spacing: 0.2px;
        }

        .app-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(8px);
            background: rgba(248, 246, 241, 0.86);
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .app-nav .navbar-brand {
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            text-transform: none;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        .app-nav .navbar-toggler {
            border-color: rgba(15, 23, 42, 0.2);
            background: rgba(255, 255, 255, 0.75);
        }

        .app-nav .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.2);
        }

        .app-nav .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2815,23,42,0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .app-nav .nav-link {
            color: var(--soft-ink);
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 0.45rem;
            padding: 0.45rem 0.7rem;
        }

        .app-nav .nav-link.active,
        .app-nav .nav-link:hover {
            color: #0b4f4b;
            background: rgba(15, 118, 110, 0.14);
        }

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: linear-gradient(130deg, #f7edd2 0%, #d9f2e7 52%, #bfe6ea 100%);
            color: #0f172a;
            min-height: 360px;
            margin-bottom: 1.25rem;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 54%, rgba(255, 255, 255, 0.04) 100%);
        }

        .hero-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.3rem);
            line-height: 1.04;
            margin-bottom: 0.75rem;
            color: #0f172a;
        }

        .hero p {
            max-width: 720px;
            color: rgba(15, 23, 42, 0.9);
        }

        .stat-card {
            border: 0;
            border-radius: 1rem;
            background: linear-gradient(145deg, #ffffff, #f3f5f7);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.09);
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 0;
        }

        .section-shell {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 0.5rem;
            color: var(--ink);
            font-weight: 700;
        }

        .section-subtitle {
            color: var(--soft-ink);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .book-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            height: 100%;
        }

        .book-card .cover {
            height: 180px;
            width: 100%;
            object-fit: contain;
            object-position: center;
            background: #e2e8f0;
        }

        .book-card .p-3 {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .status-pill {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .status-available {
            background: rgba(15, 118, 110, 0.13);
            color: var(--teal-dark);
        }

        .status-borrowed {
            background: rgba(159, 18, 57, 0.12);
            color: var(--danger);
        }

        .chip {
            background: var(--sand);
            color: var(--soft-ink);
            border-radius: 999px;
            padding: 0.25rem 0.7rem;
            font-size: 0.74rem;
            font-weight: 700;
            display: inline-block;
            margin: 0 0.25rem 0.25rem 0;
        }

        .timeline {
            border-left: 3px solid rgba(15, 118, 110, 0.35);
            padding-left: 1rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 0.9rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--teal);
            left: -1.43rem;
            top: 0.35rem;
        }

        .forum-post {
            border: 1px solid rgba(15, 23, 42, 0.09);
            border-radius: 0.9rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .forum-post .post-head { gap: 0.75rem; }

        .gallery-card {
            border: 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 9px 26px rgba(2, 6, 23, 0.18);
        }

        .gallery-card img,
        .gallery-card iframe {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border: 0;
        }

        details {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, 0.09);
            border-radius: 0.8rem;
            padding: 0.8rem 1rem;
            margin-bottom: 0.65rem;
        }

        details summary {
            cursor: pointer;
            font-weight: 700;
            color: #1e293b;
        }

        .flash-floating {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 1040;
            min-width: 280px;
        }

        .site-footer {
            color: #f8fafc;
            background:
                radial-gradient(circle at 5% 10%, rgba(245, 158, 11, 0.25), transparent 35%),
                linear-gradient(135deg, #0b1220 0%, #0f2f38 55%, #1b1f3a 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .site-footer h3,
        .site-footer h4 {
            color: #ffffff;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .text-footer-soft { color: rgba(226, 232, 240, 0.9); }

        .footer-links li + li { margin-top: 0.4rem; }

        .footer-links a {
            color: rgba(226, 232, 240, 0.94);
            text-decoration: none;
            transition: color .2s ease;
        }

        .footer-links a:hover { color: #facc15; }

        .footer-divider { border-color: rgba(148, 163, 184, 0.35); }

        @media (max-width: 991.98px) {
            .app-nav .navbar-collapse {
                margin-top: 0.8rem;
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(15, 23, 42, 0.08);
                border-radius: 0.75rem;
                padding: 0.6rem 0.8rem;
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
            }

            .app-nav .nav-link { padding: 0.55rem 0.4rem; }
        }

        @media (max-width: 767px) {
            .hero {
                min-height: 320px;
            }

            .hero-content {
                padding: 1.25rem;
            }

            .hero h1 {
                font-size: clamp(1.8rem, 9vw, 2.4rem);
            }

            .hero p {
                font-size: 0.95rem;
            }

            .section-shell {
                padding: 1rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .flash-floating {
                left: 0.75rem;
                right: 0.75rem;
                min-width: auto;
            }

            .forum-post .post-head {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .timeline {
                padding-left: 0.8rem;
            }

            .timeline-item::before {
                left: -1.22rem;
            }

            .table {
                min-width: 640px;
            }

            .d-flex.flex-column-mobile {
                flex-direction: column;
                align-items: stretch;
            }

            .d-flex.flex-column-mobile .btn,
            .d-flex.flex-column-mobile .form-control {
                width: 100%;
            }

            .gallery-card img,
            .gallery-card iframe {
                height: 210px;
            }
        }
    </style>
</head>
<body>
@php($userQuery = $selectedUser?->id ? ['user_id' => $selectedUser->id] : [])
@php($loggedStudentUserId = session('student_user_id'))
@php($loggedStudentName = session('student_user_name'))
@php($headerQuery = $loggedStudentUserId ? ['user_id' => $loggedStudentUserId] : $userQuery)

<nav class="app-nav navbar navbar-expand-lg">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="{{ route('library.katalog', $headerQuery) }}">
            <img class="brand-logo" src="{{ asset('template/img/Logo.png') }}" alt="Logo">
            <span>Perpustakaan SMA 25</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.katalog') || request()->routeIs('library.index') ? 'active' : '' }}" href="{{ route('library.katalog', $headerQuery) }}">Katalog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.artikel') ? 'active' : '' }}" href="{{ route('library.artikel', $headerQuery) }}">Artikel & Jurnal</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.pengumuman') ? 'active' : '' }}" href="{{ route('library.pengumuman', $headerQuery) }}">Pengumuman</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.forum') ? 'active' : '' }}" href="{{ route('library.forum', $headerQuery) }}">Forum</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.galeri') ? 'active' : '' }}" href="{{ route('library.galeri', $headerQuery) }}">Galeri</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('library.faq') ? 'active' : '' }}" href="{{ route('library.faq', $headerQuery) }}">FAQ</a></li>
            </ul>
            <div class="d-flex ms-lg-3 mt-3 mt-lg-0">
                @if ($loggedStudentUserId)
                    <div class="d-flex align-items-center gap-2">
                        <a class="btn btn-warning fw-semibold px-3" href="{{ route('library.katalog', ['user_id' => $loggedStudentUserId]) }}">{{ $loggedStudentName }}</a>
                        <form method="POST" action="{{ route('library.logout') }}" class="m-0">
                            @csrf
                            <button class="btn btn-outline-danger fw-semibold px-3" type="submit">Logout</button>
                        </form>
                    </div>
                @else
                    <a class="btn btn-warning fw-semibold px-3" href="{{ route('library.login') }}">Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<main class="container py-4 py-lg-5" id="beranda">
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>@yield('hero_title', 'Sistem Informasi Perpustakaan Berbasis Web')</h1>
            <p>@yield('hero_text', 'Platform perpustakaan sekolah dengan layanan katalog, digital resource, peminjaman, forum, dan bantuan dalam halaman yang terpisah per layer.') </p>
        </div>
    </section>

    <section class="row g-3 mb-4 mb-lg-5">
        <div class="col-6 col-lg-3">
            <article class="stat-card card h-100">
                <div class="card-body">
                    <small class="text-secondary">Total Buku</small>
                    <h3>{{ $stats['book_total'] }}</h3>
                </div>
            </article>
        </div>
        <div class="col-6 col-lg-3">
            <article class="stat-card card h-100">
                <div class="card-body">
                    <small class="text-secondary">Buku Tersedia</small>
                    <h3>{{ $stats['book_available'] }}</h3>
                </div>
            </article>
        </div>
        <div class="col-6 col-lg-3">
            <article class="stat-card card h-100">
                <div class="card-body">
                    <small class="text-secondary">Pinjaman Aktif</small>
                    <h3>{{ $stats['active_loans'] }}</h3>
                </div>
            </article>
        </div>
        <div class="col-6 col-lg-3">
            <article class="stat-card card h-100">
                <div class="card-body">
                    <small class="text-secondary">Artikel & Jurnal</small>
                    <h3>{{ $stats['digital_total'] }}</h3>
                </div>
            </article>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Validasi gagal:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

@include('library.partials.footer')

<div class="flash-floating">
    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info shadow-sm">{{ session('info') }}</div>
    @endif
</div>

<script>
    const navButton = document.querySelector('.navbar-toggler');
    const navCollapse = document.getElementById('navMain');

    navButton?.addEventListener('click', () => {
        const isOpen = navCollapse?.classList.toggle('show');
        navButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    navCollapse?.querySelectorAll('.nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                navCollapse.classList.remove('show');
                navButton?.setAttribute('aria-expanded', 'false');
            }
        });
    });

    setTimeout(() => {
        document.querySelectorAll('.flash-floating .alert').forEach((element) => {
            element.style.transition = 'all .4s ease';
            element.style.opacity = '0';
            element.style.transform = 'translateY(10px)';
            setTimeout(() => element.remove(), 450);
        });
    }, 3800);
</script>
</body>
</html>
