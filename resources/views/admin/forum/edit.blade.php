@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Edit Post Forum</h2>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.forum.update', $post) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="6" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Topik (Opsional)</label>
                        <input class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic', $post->topic) }}">
                        @error('topic')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_recommendation" value="1" id="isRecommendation" {{ old('is_recommendation', $post->is_recommendation) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isRecommendation">
                            Tandai sebagai rekomendasi buku
                        </label>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.forum.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
