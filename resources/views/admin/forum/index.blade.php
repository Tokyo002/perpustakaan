@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Forum</h2>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Topik</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($post->title, 40) }}</td>
                                <td>{{ $post->user?->name ?? '-' }}</td>
                                <td>{{ $post->topic ?? '-' }}</td>
                                <td>
                                    @if($post->is_recommendation)
                                        <span class="badge bg-success">Rekomendasi</span>
                                    @else
                                        <span class="badge bg-secondary">Diskusi</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.forum.edit', $post) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.forum.destroy', $post) }}" onsubmit="return confirm('Hapus post ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-secondary">Belum ada post forum.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
