@extends('library.layouts.app')

@section('title', 'FAQ - Perpustakaan SMA 25')
@section('hero_title', 'Layer FAQ & Bantuan')
@section('hero_text', 'Halaman khusus pertanyaan yang sering diajukan untuk pendaftaran anggota, peminjaman, dan dukungan admin.')

@section('content')
<section class="section-shell mb-4">
<section class="section-shell">
    <h2 class="section-title">FAQ & Bantuan</h2>
    <p class="section-subtitle">Panduan pendaftaran anggota, aturan peminjaman, serta bantuan admin.</p>

    <div class="row g-4">
        @forelse ($faqs as $faq)
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-600 mb-2">{{ $faq->question }}</h5>
                        <p class="card-text text-secondary small lh-lg">{{ $faq->answer }}</p>
                        @if ($faq->category)
                            <div class="mt-3">
                                <small class="badge bg-light text-dark">{{ $faq->category }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada FAQ tersedia.</div>
            </div>
        @endforelse
    </div>
</section>
@endsection
