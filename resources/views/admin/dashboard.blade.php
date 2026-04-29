@extends('admin.layouts.app')

@section('content')
<style>
    .dash-card {
        position: relative;
        overflow: hidden;
    }

    .dash-card .metric-title {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        margin-bottom: 0.35rem;
        font-weight: 700;
    }

    .dash-card .metric-value {
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
        color: #0f172a;
    }

    .mini-progress {
        height: 6px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .mini-progress > span {
        display: block;
        height: 100%;
        border-radius: inherit;
    }

    .metric-note {
        font-size: 0.78rem;
        color: #64748b;
    }

    .accent-blue { background: #2563eb; }
    .accent-green { background: #16a34a; }
    .accent-amber { background: #f59e0b; }
    .accent-red { background: #ef4444; }

    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.9rem;
    }

    .section-title {
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .label-pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        font-size: 0.74rem;
        padding: 0.2rem 0.55rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #475569;
    }

    .modern-table th {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 700;
        border-bottom-color: #e2e8f0;
    }

    .modern-table td {
        border-bottom-color: #edf2f7;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h2 class="mb-0" style="font-size: 1.35rem; font-weight: 800;">Dashboard Overview</h2>
        <small class="text-secondary">Ringkasan data real-time perpustakaan</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Laporan</a>
        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-dark">Input Transaksi</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('admin.books.index') }}" class="text-decoration-none">
            <div class="card app-card dash-card h-100">
                <div class="card-body">
                    <div class="metric-title">Total Buku Aktif</div>
                    <div class="metric-value">{{ $summary['total_books'] }}</div>
                    <div class="mini-progress mb-2"><span class="accent-blue" style="width: 78%;"></span></div>
                    <div class="metric-note">Koleksi siap pinjam</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('admin.members.index') }}" class="text-decoration-none">
            <div class="card app-card dash-card h-100">
                <div class="card-body">
                    <div class="metric-title">Member Aktif</div>
                    <div class="metric-value">{{ $summary['active_members'] }}</div>
                    <div class="mini-progress mb-2"><span class="accent-green" style="width: 68%;"></span></div>
                    <div class="metric-note">Terdaftar & terverifikasi</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('admin.borrowings.index') }}" class="text-decoration-none">
            <div class="card app-card dash-card h-100">
                <div class="card-body">
                    <div class="metric-title">Peminjaman Aktif</div>
                    <div class="metric-value">{{ $summary['active_borrowings'] }}</div>
                    <div class="mini-progress mb-2"><span class="accent-amber" style="width: 54%;"></span></div>
                    <div class="metric-note">Sedang diproses harian</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('admin.fines.index') }}" class="text-decoration-none">
            <div class="card app-card dash-card h-100">
                <div class="card-body">
                    <div class="metric-title">Denda Tertunggak</div>
                    <div class="metric-value" style="font-size:1.4rem;">Rp {{ number_format($summary['outstanding_fines'], 0, ',', '.') }}</div>
                    <div class="mini-progress mb-2"><span class="accent-red" style="width: 42%;"></span></div>
                    <div class="metric-note">Tagihan belum lunas</div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card app-card h-100">
            <div class="card-body">
                <div class="section-head">
                    <h5 class="section-title">Peminjaman Terbaru</h5>
                    <span class="label-pill">List Borrow</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle modern-table">
                        <thead>
                        <tr><th>Anggota</th><th>Buku</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        @forelse($latestBorrowings as $item)
                            <tr>
                                <td>{{ $item->member?->name }}</td>
                                <td>{{ $item->book?->title }}</td>
                                <td><span class="badge text-bg-{{ $item->status === 'aktif' ? 'warning' : 'success' }}">{{ strtoupper($item->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-secondary">Belum ada data.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card app-card h-100">
            <div class="card-body">
                <div class="section-head">
                    <h5 class="section-title">Denda Terbaru</h5>
                    <span class="label-pill">User Income</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle modern-table">
                        <thead>
                        <tr><th>Anggota</th><th>Jumlah</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        @forelse($latestFines as $item)
                            <tr>
                                <td>{{ $item->member?->name }}</td>
                                <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                <td><span class="badge text-bg-{{ $item->payment_status === 'dibayar' ? 'success' : 'danger' }}">{{ strtoupper(str_replace('_', ' ', $item->payment_status)) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-secondary">Belum ada data.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
