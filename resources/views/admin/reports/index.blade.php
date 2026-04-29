@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Laporan</h2>
<p class="text-secondary">Cetak atau unduh laporan sesuai kebutuhan operasional perpustakaan.</p>

@php
    $reports = [
        'peminjaman' => 'Laporan Peminjaman',
        'pengembalian' => 'Laporan Pengembalian',
        'denda' => 'Laporan Denda',
        'buku-populer' => 'Buku Populer',
        'anggota-aktif' => 'Anggota Aktif',
        'inventaris' => 'Inventaris Buku',
    ];
@endphp

<div class="card app-card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
            <tr><th>Jenis Laporan</th><th>Aksi Cetak</th><th>Aksi Unduh</th></tr>
            </thead>
            <tbody>
            @foreach($reports as $key => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ route('admin.reports.print', $key) }}">Lihat/Cetak</a></td>
                    <td><a class="btn btn-sm btn-success" href="{{ route('admin.reports.download', $key) }}">Unduh CSV</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
