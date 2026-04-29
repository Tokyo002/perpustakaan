@extends('library.layouts.app')

@section('title', 'Forum - Perpustakaan SMA 25')
@section('hero_title', 'Layer Forum Komunitas')
@section('hero_text', 'Halaman khusus diskusi komunitas pembaca untuk posting, komentar, dan rekomendasi buku.')

@section('content')
<section class="section-shell">
    <h2 class="section-title">Forum Komunitas</h2>
    <p class="section-subtitle">Diskusi pembaca, rekomendasi buku, dan sharing resensi antar anggota.</p>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="d-grid gap-3">
                @forelse ($forumPosts as $post)
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
                @empty
                    <div class="alert alert-info">Belum ada diskusi forum.</div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4">
            @if ($selectedUser)
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Buat Diskusi Baru</h3>
                        <form method="POST" action="{{ route('forum-posts.store') }}">
                            @csrf
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
                            <button class="btn btn-dark w-100" type="submit">Publikasikan</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    Silakan <a href="{{ route('library.login') }}" class="fw-semibold">login</a> untuk membuat diskusi.
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
