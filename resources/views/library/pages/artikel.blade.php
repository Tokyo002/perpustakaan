@extends('library.layouts.app')

@section('title', 'Artikel & Jurnal - Perpustakaan SMA 25')
@section('hero_title', 'Layer Artikel & Jurnal')
@section('hero_text', 'Halaman khusus koleksi digital untuk artikel, jurnal, dan referensi berbasis link atau PDF.')

@section('content')
<section class="section-shell mb-4">
<section class="section-shell">
    <h2 class="section-title">Artikel & Jurnal</h2>
    <p class="section-subtitle">Koleksi digital berupa PDF atau link database dengan metadata dan kebijakan akses.</p>
    <div class="row g-4">
        @forelse ($resources as $resource)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 fw-600 mb-2">{{ \Illuminate\Support\Str::limit($resource->title, 50) }}</h3>
                        <div class="flex-grow-1">
                        <p class="small text-secondary mb-2">
                            <strong>Penulis:</strong> {{ $resource->author ?? 'Tidak diketahui' }}<br>
                            <strong>Topik:</strong> {{ $resource->topic ?? '-' }}<br>
                            <strong>Tahun:</strong> {{ $resource->year ?? '-' }}
                        </p>
                        <p class="small text-secondary lh-sm">{{ \Illuminate\Support\Str::limit($resource->abstract, 100) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <span class="badge bg-{{ $resource->access_level === 'open' ? 'success' : 'warning' }}">
                                {{ $resource->access_level === 'open' ? 'Terbuka' : 'Terbatas' }}
                            </span>
                            @if ($resource->resource_url)
                                <a class="btn btn-sm btn-primary" target="_blank" href="{{ $resource->resource_url }}">
                                    {{ $resource->resource_type === 'pdf' ? 'PDF' : 'Link' }} &rarr;
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada artikel atau jurnal tersedia.</div>
            </div>
        @endforelse
    </div>
</section>
@endsection
