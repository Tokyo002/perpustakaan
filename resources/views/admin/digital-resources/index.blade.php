@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Artikel & Jurnal</h2>

<div class="card app-card mb-3">
    <div class="card-body">
        <a href="{{ route('admin.digital-resources.create') }}" class="btn btn-primary">+ Tambah Artikel/Jurnal</a>
    </div>
</div>

<div class="card app-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Judul</th>
                    <th>Topik</th>
                    <th>Tahun</th>
                    <th>Akses</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($resources as $resource)
                    <tr>
                        <td>{{ $resource->title }}</td>
                        <td>{{ $resource->topic ?? '-' }}</td>
                        <td>{{ $resource->year ?? '-' }}</td>
                        <td><span class="badge bg-{{ $resource->access_level === 'open' ? 'success' : 'warning' }}">{{ $resource->access_level }}</span></td>
                        <td>{{ strtoupper($resource->resource_type) }}</td>
                        <td class="d-flex gap-1">
                            <a class="btn btn-sm btn-warning" href="{{ route('admin.digital-resources.edit', $resource) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.digital-resources.destroy', $resource) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-secondary">Belum ada data artikel/jurnal.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $resources->links() }}
    </div>
</div>
@endsection
