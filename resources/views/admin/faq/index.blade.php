@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul FAQ</h2>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card app-card mb-3">
            <div class="card-body">
                <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">+ Tambah FAQ</a>
            </div>
        </div>

        <div class="card app-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>Pertanyaan</th>
                            <th>Kategori</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($faq->question, 50) }}</td>
                                <td>{{ $faq->category ?? '-' }}</td>
                                <td>{{ $faq->sort_order ?? '-' }}</td>
                                <td class="d-flex gap-1">
                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.faq.edit', $faq) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}" onsubmit="return confirm('Hapus FAQ ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-secondary">Belum ada FAQ.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
