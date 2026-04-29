@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Pengumuman</h2>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card app-card mb-3">
            <div class="card-body">
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">+ Tambah Pengumuman</a>
            </div>
        </div>

        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Tanggal Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($announcements as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($item->type) }}</span>
                                </td>
                                <td>{{ optional($item->published_at)->format('d M Y') ?? '-' }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.announcements.edit', $item) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $item) }}" onsubmit="return confirm('Hapus pengumuman ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-secondary">Belum ada pengumuman.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
