<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Member;
use App\Models\ReturnRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        return view('admin.reports.index', [
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function print(Request $request, string $type): View
    {
        [$title, $rows] = $this->reportData($type);

        return view('admin.reports.print', [
            'title' => $title,
            'type' => $type,
            'rows' => $rows,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function download(string $type): StreamedResponse
    {
        [, $rows] = $this->reportData($type);

        $headers = array_keys(($rows->first() ?? ['data' => '-']));
        $filename = 'laporan-' . $type . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($headers, $rows): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, $headers);

            foreach ($rows as $row) {
                fputcsv($stream, array_values($row));
            }

            fclose($stream);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function reportData(string $type): array
    {
        return match ($type) {
            'peminjaman' => [
                'Laporan Peminjaman',
                Borrowing::query()
                    ->with(['member', 'book'])
                    ->latest()
                    ->get()
                    ->map(fn (Borrowing $row) => [
                        'anggota' => $row->member?->name,
                        'buku' => $row->book?->title,
                        'tanggal_pinjam' => optional($row->borrowed_at)->format('Y-m-d'),
                        'jatuh_tempo' => optional($row->due_at)->format('Y-m-d'),
                        'status' => $row->status,
                    ]),
            ],
            'pengembalian' => [
                'Laporan Pengembalian',
                ReturnRecord::query()
                    ->with(['member', 'book'])
                    ->latest()
                    ->get()
                    ->map(fn (ReturnRecord $row) => [
                        'anggota' => $row->member?->name,
                        'buku' => $row->book?->title,
                        'batas_kembali' => optional($row->due_date)->format('Y-m-d'),
                        'tanggal_kembali' => optional($row->returned_at)->format('Y-m-d'),
                        'keterlambatan_hari' => $row->late_days,
                        'kondisi' => $row->book_condition,
                    ]),
            ],
            'denda' => [
                'Laporan Denda',
                Fine::query()
                    ->with(['member', 'book'])
                    ->latest()
                    ->get()
                    ->map(fn (Fine $row) => [
                        'anggota' => $row->member?->name,
                        'buku' => $row->book?->title,
                        'jenis_denda' => $row->fine_type,
                        'jumlah_denda' => $row->amount,
                        'dibayar' => $row->paid_amount,
                        'sisa' => $row->remaining_amount,
                        'status' => $row->payment_status,
                    ]),
            ],
            'buku-populer' => [
                'Laporan Buku Populer',
                Borrowing::query()
                    ->select('book_id', DB::raw('COUNT(*) as total_pinjam'))
                    ->with('book')
                    ->groupBy('book_id')
                    ->orderByDesc('total_pinjam')
                    ->get()
                    ->map(fn (Borrowing $row) => [
                        'buku' => $row->book?->title,
                        'total_dipinjam' => $row->total_pinjam,
                    ]),
            ],
            'anggota-aktif' => [
                'Laporan Anggota Aktif',
                Member::query()
                    ->where('is_active', true)
                    ->withCount('borrowings')
                    ->orderByDesc('borrowings_count')
                    ->get()
                    ->map(fn (Member $row) => [
                        'nomor_anggota' => $row->member_number,
                        'nama' => $row->name,
                        'jenis' => $row->member_type,
                        'kelas_jabatan' => $row->class_or_position,
                        'total_peminjaman' => $row->borrowings_count,
                    ]),
            ],
            'inventaris' => [
                'Laporan Inventaris Buku',
                Book::query()
                    ->withCount('copies')
                    ->orderBy('title')
                    ->get()
                    ->map(fn (Book $row) => [
                        'judul' => $row->title,
                        'pengarang' => $row->author,
                        'kategori' => $row->category?->name,
                        'stok' => $row->stock,
                        'total_eksemplar' => $row->copies_count,
                        'status' => $row->is_available ? 'tersedia' : 'dipinjam',
                    ]),
            ],
            default => ['Laporan Tidak Ditemukan', collect([['data' => '-']])],
        };
    }
}
