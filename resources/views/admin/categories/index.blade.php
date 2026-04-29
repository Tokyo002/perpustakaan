@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Kategori Buku</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editCategory ? 'Edit Kategori' : 'Tambah Kategori' }}</h5>
                <form method="POST" action="{{ $editCategory ? route('admin.categories.update', $editCategory) : route('admin.categories.store') }}">
                    @csrf
                    @if($editCategory)
                        @method('PUT')
                    @endif
                    <div class="mb-2">
                        <label class="form-label">Nama Kategori</label>
                        <input class="form-control" name="name" value="{{ old('name', $editCategory->name ?? '') }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" rows="3" name="description">{{ old('description', $editCategory->description ?? '') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editCategory)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.categories.index') }}">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr><th>Nama Kategori</th><th>Deskripsi</th><th>Jumlah Buku</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->books_count }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.categories.index', ['edit' => $item->id]) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $item) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-secondary">Belum ada kategori.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
