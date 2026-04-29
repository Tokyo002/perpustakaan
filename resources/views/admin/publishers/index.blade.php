@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Penerbit</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editPublisher ? 'Edit Penerbit' : 'Tambah Penerbit' }}</h5>
                <form method="POST" action="{{ $editPublisher ? route('admin.publishers.update', $editPublisher) : route('admin.publishers.store') }}">
                    @csrf
                    @if($editPublisher)
                        @method('PUT')
                    @endif
                    <div class="mb-2">
                        <label class="form-label">Nama Penerbit</label>
                        <input class="form-control" name="name" value="{{ old('name', $editPublisher->name ?? '') }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" rows="2">{{ old('address', $editPublisher->address ?? '') }}</textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kontak</label>
                        <input class="form-control" name="contact" value="{{ old('contact', $editPublisher->contact ?? '') }}">
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editPublisher)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.publishers.index') }}">Batal</a>
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
                        <tr><th>Nama</th><th>Alamat</th><th>Kontak</th><th>Jumlah Buku</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                        @forelse($publishers as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->contact }}</td>
                                <td>{{ $item->books_count }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.publishers.index', ['edit' => $item->id]) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.publishers.destroy', $item) }}" onsubmit="return confirm('Hapus penerbit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-secondary">Belum ada penerbit.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
