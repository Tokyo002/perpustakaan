@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Tambah FAQ</h2>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.faq.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required>
                        @error('question')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" rows="6" required>{{ old('answer') }}</textarea>
                        @error('answer')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori (Opsional)</label>
                        <input class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}">
                        @error('category')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan (Opsional)</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" name="sort_order" value="{{ old('sort_order') }}" min="0">
                        @error('sort_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.faq.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
