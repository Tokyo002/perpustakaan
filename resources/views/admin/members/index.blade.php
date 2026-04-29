@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Anggota</h2>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card app-card">
            <div class="card-body">
                <h5>{{ $editMember ? 'Edit Anggota' : 'Tambah Anggota' }}</h5>
                <form method="POST" action="{{ $editMember ? route('admin.members.update', $editMember) : route('admin.members.store') }}">
                    @csrf
                    @if($editMember)
                        @method('PUT')
                    @endif
                    <div class="mb-2"><label class="form-label">Nomor Anggota</label><input class="form-control" name="member_number" value="{{ old('member_number', $editMember->member_number ?? '') }}" required></div>
                    <div class="mb-2"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ old('name', $editMember->name ?? '') }}" required></div>
                    <div class="mb-2"><label class="form-label">Jenis Anggota</label>
                        <select class="form-select" name="member_type" required>
                            <option value="siswa" @selected(old('member_type', $editMember->member_type ?? 'siswa') === 'siswa')>Siswa</option>
                            <option value="guru" @selected(old('member_type', $editMember->member_type ?? '') === 'guru')>Guru</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Kelas / Jabatan</label><input class="form-control" name="class_or_position" value="{{ old('class_or_position', $editMember->class_or_position ?? '') }}"></div>
                    <div class="mb-2"><label class="form-label">Kontak</label><input class="form-control" name="contact" value="{{ old('contact', $editMember->contact ?? '') }}"></div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="memberActive" @checked(old('is_active', $editMember->is_active ?? true))>
                        <label class="form-check-label" for="memberActive">Aktif</label>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    @if($editMember)
                        <a class="btn btn-outline-secondary" href="{{ route('admin.members.index') }}">Batal</a>
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
                    <tr><th>No Anggota</th><th>Nama</th><th>Jenis</th><th>Kelas/Jabatan</th><th>Kontak</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                    @forelse($members as $item)
                        <tr>
                            <td>{{ $item->member_number }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ ucfirst($item->member_type) }}</td>
                            <td>{{ $item->class_or_position }}</td>
                            <td>{{ $item->contact }}</td>
                            <td><span class="badge text-bg-{{ $item->is_active ? 'success' : 'secondary' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="d-flex gap-1">
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.members.index', ['edit' => $item->id]) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $item) }}" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-secondary">Belum ada data anggota.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
