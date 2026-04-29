@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Eksemplar Buku</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editCopy ? 'Edit Eksemplar' : 'Tambah Eksemplar' }}</h5>
                <form method="POST" action="{{ $editCopy ? route('admin.copies.update', $editCopy) : route('admin.copies.store') }}">
                    @csrf
                    @if($editCopy)
                        @method('PUT')
                    @endif
                    <div class="mb-2">
                        <label class="form-label">Buku</label>
                        <select class="form-select" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" @selected(old('book_id', $editCopy->book_id ?? '') == $book->id)>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Kode Eksemplar</label><input class="form-control" name="copy_code" value="{{ old('copy_code', $editCopy->copy_code ?? '') }}" required></div>
                    <div class="mb-2"><label class="form-label">Jumlah Buku</label><input type="number" min="1" class="form-control" name="quantity" value="{{ old('quantity', $editCopy->quantity ?? 1) }}" required></div>
                    <div class="mb-2"><label class="form-label">Lokasi Rak</label><input class="form-control" name="rack_location" value="{{ old('rack_location', $editCopy->rack_location ?? '') }}"></div>
                    <div class="mb-2"><label class="form-label">Kondisi</label>
                        <select class="form-select" name="condition" required>
                            @foreach(['baik' => 'Baik','rusak_ringan' => 'Rusak Ringan','rusak_berat' => 'Rusak Berat'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('condition', $editCopy->condition ?? 'baik') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="tersedia" @selected(old('status', $editCopy->status ?? 'tersedia') === 'tersedia')>Tersedia</option>
                            <option value="dipinjam" @selected(old('status', $editCopy->status ?? '') === 'dipinjam')>Dipinjam</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editCopy)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.copies.index') }}">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr><th>Kode</th><th>Buku</th><th>Jumlah</th><th>Lokasi Rak</th><th>Kondisi</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($copies as $item)
                        <tr>
                            <td>{{ $item->copy_code }}</td>
                            <td>{{ $item->book?->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->rack_location }}</td>
                            <td>{{ str_replace('_', ' ', $item->condition) }}</td>
                            <td>{{ $item->status }}</td>
                            <td class="d-flex gap-1">
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.copies.index', ['edit' => $item->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.copies.destroy', $item) }}" onsubmit="return confirm('Hapus eksemplar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-secondary">Belum ada eksemplar buku.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
