@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Denda</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editFine ? 'Edit Denda' : 'Tambah Denda' }}</h5>
                <form method="POST" action="{{ $editFine ? route('admin.fines.update', $editFine) : route('admin.fines.store') }}">
                    @csrf
                    @if($editFine)
                        @method('PUT')
                    @endif
                    <div class="mb-2"><label class="form-label">Anggota</label>
                        <select class="form-select" name="member_id" required>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" @selected(old('member_id', $editFine->member_id ?? '') == $member->id)>{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Buku</label>
                        <select class="form-select" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" @selected(old('book_id', $editFine->book_id ?? '') == $book->id)>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Jenis Denda</label><input class="form-control" name="fine_type" value="{{ old('fine_type', $editFine->fine_type ?? 'keterlambatan') }}" required></div>
                    <div class="mb-2"><label class="form-label">Hari Keterlambatan</label><input type="number" min="0" class="form-control" name="late_days" value="{{ old('late_days', $editFine->late_days ?? 0) }}"></div>
                    <div class="mb-2"><label class="form-label">Jumlah Denda</label><input type="number" min="0" step="0.01" class="form-control" name="amount" value="{{ old('amount', $editFine->amount ?? 0) }}" required></div>
                    <div class="mb-2"><label class="form-label">Pembayaran</label><input type="number" min="0" step="0.01" class="form-control" name="paid_amount" value="{{ old('paid_amount', $editFine->paid_amount ?? 0) }}"></div>
                    <div class="mb-2"><label class="form-label">Catatan</label><textarea class="form-control" name="notes">{{ old('notes', $editFine->notes ?? '') }}</textarea></div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editFine)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.fines.index') }}">Batal</a>
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
                    <tr><th>Anggota</th><th>Buku</th><th>Jenis</th><th>Hari</th><th>Jumlah</th><th>Sisa</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($fines as $item)
                        <tr>
                            <td>{{ $item->member?->name }}</td>
                            <td>{{ $item->book?->title }}</td>
                            <td>{{ $item->fine_type }}</td>
                            <td>{{ $item->late_days }}</td>
                            <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->remaining_amount, 0, ',', '.') }}</td>
                            <td>{{ strtoupper(str_replace('_', ' ', $item->payment_status)) }}</td>
                            <td class="d-flex gap-1">
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.fines.index', ['edit' => $item->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.fines.destroy', $item) }}" onsubmit="return confirm('Hapus denda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-secondary">Belum ada data denda.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
