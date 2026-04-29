@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Tambah Pengumuman</h2>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.announcements.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="news" {{ old('type') === 'news' ? 'selected' : '' }}>News</option>
                            <option value="policy" {{ old('type') === 'policy' ? 'selected' : '' }}>Policy</option>
                            <option value="event" {{ old('type') === 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                        @error('type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="6" required>{{ old('content') }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Publikasi (Opsional)</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror" name="published_at" value="{{ old('published_at') }}">
                        @error('published_at')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.announcements.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
