@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Edit Artikel & Jurnal</h2>

<div class="card app-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.digital-resources.update', $resource) }}" class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <label class="form-label">Judul</label>
                <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $resource->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Tahun</label>
                <input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $resource->year) }}" min="1900" max="2100">
                @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Penulis</label>
                <input class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $resource->author) }}">
                @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Topik</label>
                <input class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{ old('topic', $resource->topic) }}">
                @error('topic')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Akses</label>
                <select class="form-select @error('access_level') is-invalid @enderror" name="access_level" required>
                    <option value="open" {{ old('access_level', $resource->access_level) === 'open' ? 'selected' : '' }}>open</option>
                    <option value="limited" {{ old('access_level', $resource->access_level) === 'limited' ? 'selected' : '' }}>limited</option>
                </select>
                @error('access_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipe Resource</label>
                <select class="form-select @error('resource_type') is-invalid @enderror" name="resource_type" required>
                    <option value="link" {{ old('resource_type', $resource->resource_type) === 'link' ? 'selected' : '' }}>link</option>
                    <option value="pdf" {{ old('resource_type', $resource->resource_type) === 'pdf' ? 'selected' : '' }}>pdf</option>
                </select>
                @error('resource_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">URL Resource</label>
                <input class="form-control @error('resource_url') is-invalid @enderror" name="resource_url" value="{{ old('resource_url', $resource->resource_url) }}">
                @error('resource_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label">Abstrak</label>
                <textarea class="form-control @error('abstract') is-invalid @enderror" rows="4" name="abstract">{{ old('abstract', $resource->abstract) }}</textarea>
                @error('abstract')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.digital-resources.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
