@extends('library.layouts.app')

@section('title', 'Katalog Buku - Perpustakaan SMA 25')
@section('hero_title', 'Layer Katalog Buku')
@section('hero_text', 'Halaman khusus katalog untuk pencarian buku berdasarkan judul, penulis, kategori, genre, bahasa, dan status ketersediaan.')

@section('content')
<section class="section-shell mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">
        <div>
            <h2 class="section-title">Katalog Buku</h2>
            <p class="text-secondary mb-0">Cari buku berdasarkan judul, penulis, genre, bahasa, kategori, dan status ketersediaan.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('library.katalog') }}" class="row g-2 mb-4">
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
            <a class="btn btn-outline-secondary" href="{{ route('library.katalog', ['user_id' => $selectedUser?->id]) }}">Reset</a>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($books as $book)
            <div class="col-md-6 col-lg-4">
                <article class="book-card">
                    <img class="cover" src="{{ $book->cover_image_url }}" alt="Cover {{ $book->title }}">
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
@endsection
