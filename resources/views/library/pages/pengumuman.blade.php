@extends('library.layouts.app')

@section('title', 'Pengumuman - Perpustakaan SMA 25')
@section('hero_title', 'Layer Pengumuman')
@section('hero_text', 'Halaman khusus berita, kebijakan, dan jadwal acara perpustakaan yang diperbarui berkala.')

@section('content')
<section class="section-shell mb-4">
<section class="section-shell">
    <h2 class="section-title">Berita & Pengumuman</h2>
    <p class="section-subtitle">Informasi terbaru dan pengumuman penting dari perpustakaan.</p>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="d-grid gap-3">
            @foreach ($announcements as $announcement)
                <article class="card border-0 shadow-sm">
                    <div class="card-body pb-3 pt-3">
                        <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                            <span class="badge bg-primary">{{ ucfirst($announcement->type) }}</span>
                            <small class="text-secondary fw-500">{{ optional($announcement->published_at)->format('d M Y') }}</small>
                        </div>
                        <h3 class="h5 fw-600 mb-2">{{ $announcement->title }}</h3>
                        <p class="mb-0 text-secondary lh-lg">{{ \Illuminate\Support\Str::limit($announcement->content, 200) }}</p>
                    </div>
                </article>
            @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="h5 fw-600 mb-3">Jadwal Acara Rutin</h3>
                    <div class="timeline">
                        @forelse ($events as $event)
                            <div class="timeline-item">
                                <h4 class="h6 fw-600 mb-1">{{ $event->title }}</h4>
                                <p class="small text-secondary mb-1">
                                    {{ optional($event->event_date)->format('d M Y') }}
                                    @if ($event->start_time)
                                        | {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }}
                                    @endif
                                </p>
                                <p class="small mb-1">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                            </div>
                        @empty
                            <p class="small text-secondary">Belum ada acara terjadwal.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
