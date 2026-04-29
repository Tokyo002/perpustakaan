<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan SMA Muhammadiyah 25 Setiabudi Pamulang</title>
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

        * {
            box-sizing: border-box;
        }

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
            background: rgba(248, 246, 241, 0.82);
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }
        .app-nav .navbar-brand {
            color: var(--ink);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            letter-spacing: 0.3px;
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
        }

        .app-nav .nav-link:hover {
            color: var(--teal-dark);
        }

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: #0f172a;
            color: #fff;
            min-height: 480px;
        }

        .hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.28;
            transform: scale(1.05);
            animation: heroZoom 8s ease forwards;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, rgba(15, 23, 42, 0.86) 0%, rgba(15, 23, 42, 0.55) 54%, rgba(15, 118, 110, 0.3) 100%);
        }

        .hero-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        .hero-logo {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.55);
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.7rem);
            line-height: 1.03;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 0.9s ease forwards;
            animation-delay: 0.08s;
        }

        .hero p {
            max-width: 680px;
            color: rgba(248, 250, 252, 0.9);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.16s;
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
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 1.3rem;
        }
        .app-nav .navbar-collapse {
            transition: all 0.25s ease;
        }
        .book-card .p-3 {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }
        .forum-post .post-head {
            gap: 0.75rem;
        }
        .table-responsive {
            border-radius: 0.75rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 0.15rem;
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
            object-fit: cover;
            background: #e2e8f0;
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

        .gallery-card {
            border: 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 9px 26px rgba(2, 6, 23, 0.18);
        }

        .gallery-card img, .gallery-card iframe {
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

        .text-footer-soft {
            color: rgba(226, 232, 240, 0.9);
        }

        .footer-links li + li {
            margin-top: 0.4rem;
        }

        .footer-links a {
            color: rgba(226, 232, 240, 0.94);
            text-decoration: none;
            transition: color .2s ease;
        }

        .footer-links a:hover {
            color: #facc15;
        }

        .footer-divider {
            border-color: rgba(148, 163, 184, 0.35);
        }

        @keyframes heroZoom {
            from { transform: scale(1.1); }
            to { transform: scale(1.02); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 767px) {
            .hero {
                min-height: 450px;
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
            .section-shell .btn {
                width: 100%;
            }
            .section-shell .d-flex.flex-column-mobile {
                flex-direction: column;
                align-items: stretch;
            }
            .section-shell .d-flex.flex-column-mobile .btn,
            .section-shell .d-flex.flex-column-mobile .form-control {
                width: 100%;
            }

                    @media (max-width: 991.98px) {
                        .app-nav .navbar-collapse {
                            margin-top: 0.8rem;
                            background: rgba(255, 255, 255, 0.96);
                            border: 1px solid rgba(15, 23, 42, 0.08);
                            border-radius: 0.75rem;
                            padding: 0.6rem 0.8rem;
                            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
                        }
                        .app-nav .nav-link {
                            padding: 0.55rem 0.1rem;
                        }
                    }
                    @media (min-width: 768px) and (max-width: 1199.98px) {
                        .book-card .cover {
                            height: 210px;
                        }
                    }
            .gallery-card img,
            .gallery-card iframe {
                height: 210px;
            }
        }
    </style>
</head>
<body>
    <nav class="app-nav navbar navbar-expand-lg">
        <div class="container py-2">
            <a class="navbar-brand fw-bold" href="#beranda">Perpustakaan SMA 25</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#katalog">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#artikel">Artikel & Jurnal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pengumuman">Pengumuman</a></li>
                    <li class="nav-item"><a class="nav-link" href="#akun">Akun</a></li>
                    <li class="nav-item"><a class="nav-link" href="#forum">Forum</a></li>
                    <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5" id="beranda">
        <section class="hero mb-4 mb-lg-5">
            <img src="{{ asset('template/img/buku.jpg') }}" alt="Hero Perpustakaan">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <img class="hero-logo" src="{{ asset('template/img/Logo.png') }}" alt="Logo Perpustakaan">
                <h1>Sistem Informasi Perpustakaan Berbasis Web</h1>
                <p>
                    Rancang Bangun Sistem Informasi Perpustakaan Berbasis Web pada SMA Muhammadiyah 25 Setiabudi Pamulang menggunakan Laravel.
                    Platform ini menyatukan katalog buku, sumber digital, peminjaman online, komunitas pembaca, dan pusat bantuan dalam satu ruang.
                </p>
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

        <section id="katalog" class="section-shell mb-4 mb-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">
                <div>
                    <h2 class="section-title">Katalog Buku</h2>
                    <p class="text-secondary mb-0">Cari buku berdasarkan judul, penulis, genre, bahasa, kategori, dan status ketersediaan.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('library.index') }}" class="row g-2 mb-4">
                @if ($selectedUser)
                    <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                @endif
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari judul, penulis, ISBN" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="category_id">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? '') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="genre" placeholder="Genre" value="{{ $filters['genre'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="language" placeholder="Bahasa" value="{{ $filters['language'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="availability">
                        <option value="">Semua Status</option>
                        <option value="available" @selected(($filters['availability'] ?? '') === 'available')>Tersedia</option>
                        <option value="borrowed" @selected(($filters['availability'] ?? '') === 'borrowed')>Dipinjam</option>
                    </select>
                </div>
                <div class="col-12 d-flex gap-2 flex-column-mobile">
                    <button class="btn btn-dark" type="submit">Filter</button>
                    <a class="btn btn-outline-secondary" href="{{ route('library.index', ['user_id' => $selectedUser?->id]) }}">Reset</a>
                </div>
            </form>

            <div class="row g-3">
                @forelse ($books as $book)
                    <div class="col-md-6 col-lg-4">
                        <article class="book-card">
                            <img class="cover" src="{{ $book->cover_image ? asset($book->cover_image) : asset('template/img/buku.jpg') }}" alt="Cover {{ $book->title }}">
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h3 class="h5 mb-0">{{ $book->title }}</h3>
                                    <span class="status-pill {{ $book->is_available ? 'status-available' : 'status-borrowed' }}">
                                        {{ $book->is_available ? 'Tersedia' : 'Dipinjam' }}
                                    </span>
                                </div>
                                <div class="small text-secondary mb-2">
                                    <div>Penulis: {{ $book->author }}</div>
                                    <div>Penerbit: {{ $book->publisher ?? '-' }} ({{ $book->published_year ?? '-' }})</div>
                                    <div>ISBN: {{ $book->isbn ?? '-' }}</div>
                                </div>
                                <div class="mb-2">
                                    <span class="chip">{{ $book->category?->name ?? 'Tanpa kategori' }}</span>
                                    <span class="chip">{{ $book->genre ?? 'Umum' }}</span>
                                    <span class="chip">{{ $book->language }}</span>
                                </div>
                                <p class="small mb-2">{{ $book->abstract ?? 'Belum ada abstrak buku.' }}</p>
                                <p class="small text-secondary mb-2">
                                    Rating: {{ number_format((float) ($book->reviews_avg_rating ?? 0), 1) }} / 5
                                    ({{ $book->reviews_count }} ulasan)
                                </p>

                                @if ($selectedUser)
                                    <form method="POST" action="{{ route('wishlists.store') }}" class="d-flex gap-2 mb-2 flex-column-mobile">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <input type="text" class="form-control form-control-sm" name="notes" placeholder="Catatan wishlist">
                                        <button class="btn btn-outline-dark btn-sm" type="submit">Wishlist</button>
                                    </form>

                                    @if ($book->is_available)
                                        <form method="POST" action="{{ route('loans.store') }}" class="d-flex flex-wrap gap-2 flex-column-mobile">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="date" class="form-control form-control-sm" name="due_at" required>
                                            <button class="btn btn-sm btn-success" type="submit">Pinjam</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">Tidak ada buku yang sesuai filter.</div>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="artikel" class="section-shell mb-4 mb-lg-5">
            <h2 class="section-title">Artikel & Jurnal</h2>
            <p class="text-secondary">Koleksi digital berupa PDF atau link database dengan metadata dan kebijakan akses.</p>
            <div class="row g-3">
                @foreach ($resources as $resource)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="h5">{{ $resource->title }}</h3>
                                <p class="small text-secondary mb-2">
                                    Penulis: {{ $resource->author ?? '-' }}<br>
                                    Topik: {{ $resource->topic ?? '-' }}<br>
                                    Tahun: {{ $resource->year ?? '-' }}
                                </p>
                                <p class="small">{{ $resource->abstract ?? '-' }}</p>
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <span class="badge text-bg-{{ $resource->access_level === 'open' ? 'success' : 'secondary' }}">
                                        {{ $resource->access_level === 'open' ? 'Akses Terbuka' : 'Akses Terbatas' }}
                                    </span>
                                    @if ($resource->resource_url)
                                        <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ $resource->resource_url }}">
                                            {{ $resource->resource_type === 'pdf' ? 'Buka PDF' : 'Buka Link' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="pengumuman" class="section-shell mb-4 mb-lg-5">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h2 class="section-title">Berita & Pengumuman</h2>
                    @foreach ($announcements as $announcement)
                        <article class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-bg-dark text-uppercase">{{ $announcement->type }}</span>
                                    <small class="text-secondary">{{ optional($announcement->published_at)->format('d M Y') ?? '-' }}</small>
                                </div>
                                <h3 class="h5">{{ $announcement->title }}</h3>
                                <p class="mb-0 text-secondary">{{ $announcement->content }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Jadwal Acara Rutin</h2>
                    <div class="timeline mt-2">
                        @foreach ($events as $event)
                            <div class="timeline-item">
                                <h3 class="h5 mb-1">{{ $event->title }}</h3>
                                <p class="small text-secondary mb-1">
                                    {{ optional($event->event_date)->format('d M Y') }}
                                    @if ($event->start_time)
                                        | {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                                    @endif
                                    @if ($event->end_time)
                                        - {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('H:i') }}
                                    @endif
                                </p>
                                <p class="mb-1">{{ $event->description }}</p>
                                <small class="text-secondary">Lokasi: {{ $event->location ?? '-' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="forum" class="section-shell mb-4 mb-lg-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h2 class="section-title">Forum / Komunitas</h2>
                    <p class="text-secondary">Diskusi pembaca, rekomendasi buku, dan sharing resensi antar anggota.</p>

                    @if ($selectedUser)
                        <form method="POST" action="{{ route('forum-posts.store') }}" class="card border-0 shadow-sm">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                <div class="mb-2">
                                    <input class="form-control" type="text" name="title" placeholder="Judul diskusi" required>
                                </div>
                                <div class="mb-2">
                                    <input class="form-control" type="text" name="topic" placeholder="Topik (opsional)">
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control" rows="4" name="content" placeholder="Tulis diskusi atau resensi" required></textarea>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="isRecommendation" name="is_recommendation">
                                    <label class="form-check-label" for="isRecommendation">Tandai sebagai rekomendasi buku</label>
                                </div>
                                <button class="btn btn-dark" type="submit">Publikasikan</button>
                            </div>
                        </form>
                    @endif
                </div>

                <div class="col-lg-8">
                    <div class="d-grid gap-3">
                        @foreach ($forumPosts as $post)
                            <article class="forum-post p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2 post-head">
                                    <div>
                                        <h3 class="h5 mb-0">{{ $post->title }}</h3>
                                        <small class="text-secondary">oleh {{ $post->user?->name }} | {{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if ($post->is_recommendation)
                                        <span class="badge text-bg-success">Rekomendasi</span>
                                    @endif
                                </div>
                                @if ($post->topic)
                                    <div class="chip">{{ $post->topic }}</div>
                                @endif
                                <p class="mb-3">{{ $post->content }}</p>

                                <h4 class="h6">Komentar</h4>
                                @forelse ($post->comments as $comment)
                                    <div class="bg-white rounded border p-2 mb-2">
                                        <strong>{{ $comment->user?->name }}</strong>
                                        <small class="text-secondary"> - {{ $comment->created_at->format('d M Y H:i') }}</small>
                                        <div>{{ $comment->content }}</div>
                                    </div>
                                @empty
                                    <p class="text-secondary small">Belum ada komentar.</p>
                                @endforelse

                                @if ($selectedUser)
                                    <form method="POST" action="{{ route('forum-comments.store') }}" class="d-flex gap-2 mt-2 flex-column-mobile">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                                        <input type="hidden" name="forum_post_id" value="{{ $post->id }}">
                                        <input class="form-control" type="text" name="content" placeholder="Tulis komentar" required>
                                        <button class="btn btn-outline-dark" type="submit">Kirim</button>
                                    </form>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="section-shell mb-4 mb-lg-5">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h2 class="section-title">Tentang Perpustakaan</h2>
                    <p class="mb-2">
                        Perpustakaan SMA Muhammadiyah 25 Setiabudi Pamulang berdiri sebagai pusat literasi sekolah untuk mendukung budaya belajar,
                        riset siswa, dan penguatan karakter melalui kegiatan membaca.
                    </p>
                    <h3 class="h4 mt-3">Visi</h3>
                    <p class="mb-2">Menjadi perpustakaan sekolah yang inovatif, inklusif, dan berbasis teknologi.</p>
                    <h3 class="h4 mt-3">Misi</h3>
                    <ul>
                        <li>Menyediakan koleksi cetak dan digital yang relevan dengan kurikulum.</li>
                        <li>Membangun komunitas pembelajar aktif melalui forum, seminar, dan bedah buku.</li>
                        <li>Menerapkan layanan perpustakaan digital yang cepat, akurat, dan transparan.</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="h4">Tim Pengelola</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0"><strong>Kepala Perpustakaan:</strong> Dra. Nur Aisyah</li>
                                <li class="list-group-item px-0"><strong>Pustakawan:</strong> Rahmat Hidayat, S.IP</li>
                                <li class="list-group-item px-0"><strong>Admin Sistem:</strong> Tim IT Sekolah</li>
                                <li class="list-group-item px-0"><strong>Kontak:</strong> perpus@sma25.sch.id | 0812-0000-2525</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="galeri" class="section-shell mb-4 mb-lg-5">
            <h2 class="section-title">Galeri Foto / Video</h2>
            <p class="text-secondary">Dokumentasi kegiatan perpustakaan dan suasana ruang baca.</p>
            <div class="row g-3">
                @foreach ($galleryItems as $item)
                    <div class="col-lg-3 col-md-6">
                        <article class="gallery-card card h-100">
                            @if ($item->media_type === 'video')
                                <iframe src="{{ $item->media_url }}" allowfullscreen title="{{ $item->title }}"></iframe>
                            @else
                                <img src="{{ asset($item->media_url) }}" alt="{{ $item->title }}">
                            @endif
                            <div class="card-body">
                                <h3 class="h5 mb-1">{{ $item->title }}</h3>
                                <p class="small text-secondary mb-0">{{ $item->caption }}</p>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="faq" class="section-shell mb-4">
            <h2 class="section-title">FAQ & Bantuan</h2>
            <p class="text-secondary">Panduan pendaftaran anggota, aturan peminjaman, serta bantuan admin.</p>

            @foreach ($faqs as $faq)
                <details>
                    <summary>{{ $faq->question }}</summary>
                    <div class="mt-2 text-secondary">{{ $faq->answer }}</div>
                    @if ($faq->category)
                        <small class="text-muted">Kategori: {{ $faq->category }}</small>
                    @endif
                </details>
            @endforeach
        </section>
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
