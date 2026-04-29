@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Pengembalian</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editReturn ? 'Edit Pengembalian' : 'Tambah Pengembalian' }}</h5>
                <form method="POST" action="{{ $editReturn ? route('admin.returns.update', $editReturn) : route('admin.returns.store') }}">
                    @csrf
                    @if($editReturn)
                        @method('PUT')
                    @endif
                    @if(!$editReturn)
                        <div class="mb-2"><label class="form-label">Transaksi Peminjaman Aktif</label>
                            <select class="form-select" name="borrowing_id" required>
                                @foreach($activeBorrowings as $borrowing)
                                    <option value="{{ $borrowing->id }}">
                                        {{ $borrowing->member?->name }} - {{ $borrowing->book?->title }} (Batas: {{ optional($borrowing->due_at)->format('d-m-Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mb-2"><label class="form-label">Tanggal Pengembalian</label><input type="date" class="form-control" name="returned_at" value="{{ old('returned_at', optional($editReturn->returned_at ?? now())->format('Y-m-d')) }}" required></div>
                    <div class="mb-2"><label class="form-label">Kondisi Buku</label>
                        <select class="form-select" name="book_condition" required>
                            <option value="baik" @selected(old('book_condition', $editReturn->book_condition ?? 'baik') === 'baik')>Baik</option>
                            <option value="rusak_ringan" @selected(old('book_condition', $editReturn->book_condition ?? '') === 'rusak_ringan')>Rusak Ringan</option>
                            <option value="rusak_berat" @selected(old('book_condition', $editReturn->book_condition ?? '') === 'rusak_berat')>Rusak Berat</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editReturn)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.returns.index') }}">Batal</a>
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
                    <tr><th>Anggota</th><th>Buku</th><th>Batas Kembali</th><th>Tgl Kembali</th><th>Kondisi</th><th>Terlambat</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($returns as $item)
                        <tr>
                            <td>{{ $item->borrowing?->member?->name }}</td>
                            <td>{{ $item->borrowing?->book?->title }}</td>
                            <td>{{ optional($item->due_date)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->returned_at)->format('d-m-Y') }}</td>
                            <td>{{ str_replace('_', ' ', $item->book_condition) }}</td>
                            <td>{{ $item->late_days }} hari</td>
                            <td class="d-flex gap-1">
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.returns.index', ['edit' => $item->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.returns.destroy', $item) }}" onsubmit="return confirm('Hapus data pengembalian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-secondary">Belum ada data pengembalian.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
