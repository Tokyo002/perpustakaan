@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Peminjaman</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editBorrowing ? 'Edit Peminjaman' : 'Tambah Peminjaman' }}</h5>
                <form method="POST" action="{{ $editBorrowing ? route('admin.borrowings.update', $editBorrowing) : route('admin.borrowings.store') }}">
                    @csrf
                    @if($editBorrowing)
                        @method('PUT')
                    @endif
                    <div class="mb-2"><label class="form-label">Nama Anggota</label>
                        <select class="form-select" name="member_id" required>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" @selected(old('member_id', $editBorrowing->member_id ?? '') == $member->id)>{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Buku</label>
                        <select class="form-select" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" @selected(old('book_id', $editBorrowing->book_id ?? '') == $book->id)>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Eksemplar (opsional)</label>
                        <select class="form-select" name="book_copy_id">
                            <option value="">Auto Pilih Tersedia</option>
                            @foreach($copies as $copy)
                                <option value="{{ $copy->id }}" @selected(old('book_copy_id', $editBorrowing->book_copy_id ?? '') == $copy->id)>
                                    {{ $copy->copy_code }} - {{ $copy->book?->title }} ({{ $copy->status }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Tanggal Pinjam</label><input type="date" class="form-control" name="borrowed_at" value="{{ old('borrowed_at', optional($editBorrowing->borrowed_at ?? null)->format('Y-m-d')) }}"></div>
                    <div class="mb-2"><label class="form-label">Batas Kembali (kosong=otomatis)</label><input type="date" class="form-control" name="due_at" value="{{ old('due_at', optional($editBorrowing->due_at ?? null)->format('Y-m-d')) }}"></div>
                    <div class="mb-2"><label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="aktif" @selected(old('status', $editBorrowing->status ?? 'aktif') === 'aktif')>Aktif</option>
                            <option value="kembali" @selected(old('status', $editBorrowing->status ?? '') === 'kembali')>Kembali</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editBorrowing)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.borrowings.index') }}">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card app-card">
            <div class="card-body table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($borrowings as $item)
                        <tr>
                            <td>{{ $item->member?->name }}</td>
                            <td>{{ $item->book?->title }}</td>
                            <td>{{ optional($item->borrowed_at)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->due_at)->format('d-m-Y') }}</td>
                            <td><span class="badge text-bg-{{ $item->status === 'aktif' ? 'warning' : 'success' }}">{{ strtoupper($item->status) }}</span></td>
                            <td class="d-flex gap-1">
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.borrowings.index', ['edit' => $item->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.borrowings.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-secondary">Belum ada data peminjaman.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
