@extends('library.layouts.app')

@section('title', 'Galeri - Perpustakaan SMA 25')
@section('hero_title', 'Layer Galeri')
@section('hero_text', 'Halaman khusus dokumentasi galeri perpustakaan dalam format foto dan video.')

@section('content')
<section class="section-shell">
    <h2 class="section-title">Galeri Foto & Video</h2>
    <p class="section-subtitle">Dokumentasi kegiatan perpustakaan dan suasana ruang baca.</p>
    <div class="row g-4">
        @forelse ($galleryItems as $item)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <article class="gallery-card card h-100 border-0 shadow-sm">
                    @if ($item->media_type === 'video')
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $item->media_url }}" allowfullscreen title="{{ $item->title }}"></iframe>
                        </div>
                    @else
                        <img src="{{ asset($item->media_url) }}" alt="{{ $item->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h3 class="h5 fw-600 mb-1">{{ \Illuminate\Support\Str::limit($item->title, 40) }}</h3>
                        @if ($item->caption)
                            <p class="small text-secondary mb-0">{{ \Illuminate\Support\Str::limit($item->caption, 60) }}</p>
                        @endif
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada galeri tersedia.</div>
            </div>
        @endforelse
    </div>
</section>
@endsection
