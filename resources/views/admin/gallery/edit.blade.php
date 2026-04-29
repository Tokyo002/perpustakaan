@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Edit Galeri</h2>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.gallery.update', $item) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $item->title) }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Media</label>
                        <select class="form-select @error('media_type') is-invalid @enderror" name="media_type" required>
                            <option value="image" {{ old('media_type', $item->media_type) === 'image' ? 'selected' : '' }}>Gambar</option>
                            <option value="video" {{ old('media_type', $item->media_type) === 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('media_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Media</label>
                        <input class="form-control @error('media_url') is-invalid @enderror" type="text" name="media_url" value="{{ old('media_url', $item->media_url) }}" placeholder="/storage/gallery/image.jpg atau https://...">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti URL media.</div>
                        @error('media_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    @if($item->media_url)
                        <div class="mb-3">
                            <label class="form-label d-block">File saat ini</label>
                            @if($item->media_type === 'video')
                                <video controls style="max-width: 100%; height: auto; border-radius: 8px;">
                                    <source src="{{ asset($item->media_url) }}">
                                </video>
                            @else
                                <img src="{{ asset($item->media_url) }}" alt="{{ $item->title }}" class="img-fluid rounded" style="max-height: 220px; object-fit: cover;">
                            @endif
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Caption (Opsional)</label>
                        <textarea class="form-control @error('caption') is-invalid @enderror" name="caption" rows="3">{{ old('caption', $item->caption) }}</textarea>
                        @error('caption')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.gallery.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
