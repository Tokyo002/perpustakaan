@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Buku</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editBook ? 'Edit Buku' : 'Tambah Buku' }}</h5>
                <form method="POST" action="{{ $editBook ? route('admin.books.update', $editBook) : route('admin.books.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($editBook)
                        @method('PUT')
                    @endif
                    <div class="mb-2"><label class="form-label">Kode Buku (opsional)</label><input class="form-control" name="book_code" value="{{ old('book_code', $editBook->book_code ?? '') }}" placeholder="Auto jika kosong"></div>
                    <div class="mb-2"><label class="form-label">Judul</label><input class="form-control" name="title" value="{{ old('title', $editBook->title ?? '') }}" required></div>
                    <div class="mb-2"><label class="form-label">Pengarang</label><input class="form-control" name="author" value="{{ old('author', $editBook->author ?? '') }}" required></div>
                    <div class="mb-2"><label class="form-label">Kategori</label>
                        <select class="form-select" name="category_id">
                            <option value="">-</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $editBook->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Penerbit</label>
                        <select class="form-select" name="publisher_id">
                            <option value="">-</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" @selected(old('publisher_id', $editBook->publisher_id ?? '') == $publisher->id)>{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Tahun</label><input class="form-control" type="number" name="published_year" value="{{ old('published_year', $editBook->published_year ?? '') }}"></div>
                        <div class="col-6"><label class="form-label">Eksemplar/Jumlah</label><input class="form-control" type="number" name="stock" value="{{ old('stock', $editBook->stock ?? 0) }}"></div>
                    </div>
                    <div class="mb-2"><label class="form-label">ISBN</label><input class="form-control" name="isbn" value="{{ old('isbn', $editBook->isbn ?? '') }}"></div>
                    <div class="mb-2"><label class="form-label">Genre</label><input class="form-control" name="genre" value="{{ old('genre', $editBook->genre ?? '') }}"></div>
                    <div class="mb-2"><label class="form-label">Bahasa</label><input class="form-control" name="language" value="{{ old('language', $editBook->language ?? 'Indonesia') }}"></div>
                    <div class="mb-2">
                        <label class="form-label">Cover Buku (upload file)</label>
                        <input class="form-control" type="file" name="cover_image_file" accept="image/*">
                        <div class="form-text">Kosongkan jika ingin memakai cover default atau tetap memakai cover lama saat edit.</div>
                    </div>
                    @if($editBook && $editBook->cover_image)
                        <div class="mb-2">
                            <img src="{{ $editBook->cover_image_url }}" alt="cover saat ini" width="70" height="90" style="object-fit:cover;border-radius:6px;">
                        </div>
                    @endif
                    <div class="mb-2"><label class="form-label">Abstrak</label><textarea class="form-control" name="abstract" rows="3">{{ old('abstract', $editBook->abstract ?? '') }}</textarea></div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editBook)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.books.index') }}">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                        <tr>
                            <th>Cover</th><th>Kode</th><th>Judul</th><th>Jumlah</th><th>Pengarang</th><th>Kategori</th><th>Penerbit</th><th>Tahun</th><th>Eksemplar</th><th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($books as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->cover_image_url }}" alt="cover" width="45" height="60" style="object-fit:cover;border-radius:6px;">
                                </td>
                                <td>{{ $item->book_code ?? '-' }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->author }}</td>
                                <td>{{ $item->category?->name }}</td>
                                <td>{{ $item->publisherModel?->name ?? $item->publisher }}</td>
                                <td>{{ $item->published_year }}</td>
                                <td>{{ $item->copies_count }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.books.index', ['edit' => $item->id]) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $item) }}" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-secondary">Belum ada data buku.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
