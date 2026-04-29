@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Galeri</h2>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card app-card mb-3">
            <div class="card-body">
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">+ Tambah Galeri</a>
            </div>
        </div>

        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Caption</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ strtoupper($item->media_type) }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->caption, 50) }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.gallery.edit', $item) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Hapus galeri ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-secondary">Belum ada galeri.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
