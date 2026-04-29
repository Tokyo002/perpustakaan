@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Tambah Galeri</h2>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.gallery.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Media</label>
                        <select class="form-select @error('media_type') is-invalid @enderror" name="media_type" required>
                            <option value="image" {{ old('media_type') === 'image' ? 'selected' : '' }}>Gambar</option>
                            <option value="video" {{ old('media_type') === 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('media_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Media</label>
                        <input class="form-control @error('media_url') is-invalid @enderror" type="text" name="media_url" placeholder="/storage/gallery/image.jpg atau https://..." required>
                        <div class="form-text">URL gambar atau video. Bisa dari storage lokal atau external.</div>
                        @error('media_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Caption (Opsional)</label>
                        <textarea class="form-control @error('caption') is-invalid @enderror" name="caption" rows="3">{{ old('caption') }}</textarea>
                        @error('caption')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.gallery.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
