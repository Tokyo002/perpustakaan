<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\AppSetting;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $borrowings = Borrowing::query()
            ->with(['member', 'book', 'copy'])
            ->latest()
            ->get();

        $editBorrowing = null;

        if ($request->filled('edit')) {
            $editBorrowing = Borrowing::query()->find($request->integer('edit'));
        }

        return view('admin.borrowings.index', [
            'borrowings' => $borrowings,
            'members' => Member::query()->where('is_active', true)->orderBy('name')->get(),
            'books' => Book::query()->orderBy('title')->get(),
            'copies' => BookCopy::query()->orderBy('copy_code')->get(),
            'editBorrowing' => $editBorrowing,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => ['required', 'exists:books,id'],
            'book_copy_id' => ['nullable', 'exists:book_copies,id'],
            'borrowed_at' => ['nullable', 'date'],
            'due_at' => ['nullable', 'date'],
            'status' => ['nullable', 'in:aktif,kembali'],
        ]);

        $setting = AppSetting::query()->first();
        $borrowedAt = Carbon::parse($data['borrowed_at'] ?? now()->toDateString());
        $dueAt = ! empty($data['due_at'])
            ? Carbon::parse($data['due_at'])
            : (clone $borrowedAt)->addDays((int) ($setting->loan_duration_days ?? 7));

        $copy = null;

        if (! empty($data['book_copy_id'])) {
            $copy = BookCopy::query()->find($data['book_copy_id']);
        }

        if (! $copy) {
            $copy = BookCopy::query()
                ->where('book_id', $data['book_id'])
                ->where('status', 'tersedia')
                ->first();
        }

        if (! $copy) {
            return back()->withInput()->with('error', 'Tidak ada eksemplar tersedia untuk buku ini.');
        }

        if ((int) $copy->book_id !== (int) $data['book_id']) {
            return back()->withInput()->with('error', 'Eksemplar tidak sesuai dengan buku yang dipilih.');
        }

        if ($copy->status !== 'tersedia') {
            return back()->withInput()->with('error', 'Eksemplar buku sedang dipinjam.');
        }

        $status = $data['status'] ?? 'aktif';

        $borrowing = Borrowing::query()->create([
            'member_id' => $data['member_id'],
            'book_id' => $data['book_id'],
            'book_copy_id' => $copy->id,
            'staff_user_id' => $this->currentStaffId($request),
            'borrowed_at' => $borrowedAt->toDateString(),
            'due_at' => $dueAt->toDateString(),
            'returned_at' => $status === 'kembali' ? now()->toDateString() : null,
            'status' => $status,
        ]);

        $copy->update(['status' => $status === 'aktif' ? 'dipinjam' : 'tersedia']);
        $this->syncBookAvailability((int) $borrowing->book_id);

        return redirect()->route('admin.borrowings.index')->with('success', 'Transaksi peminjaman berhasil ditambahkan.');
    }

    public function update(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => ['required', 'exists:books,id'],
            'book_copy_id' => ['nullable', 'exists:book_copies,id'],
            'borrowed_at' => ['required', 'date'],
            'due_at' => ['required', 'date'],
            'status' => ['required', 'in:aktif,kembali'],
        ]);

        $oldCopy = $borrowing->copy;
        $newCopy = ! empty($data['book_copy_id']) ? BookCopy::query()->find($data['book_copy_id']) : null;

        if ($newCopy && (int) $newCopy->book_id !== (int) $data['book_id']) {
            return back()->withInput()->with('error', 'Eksemplar tidak sesuai dengan buku yang dipilih.');
        }

        if ($newCopy && $newCopy->status !== 'tersedia' && (int) $newCopy->id !== (int) $borrowing->book_copy_id) {
            return back()->withInput()->with('error', 'Eksemplar pengganti sedang dipinjam.');
        }

        $borrowing->update([
            'member_id' => $data['member_id'],
            'book_id' => $data['book_id'],
            'book_copy_id' => $newCopy?->id,
            'borrowed_at' => $data['borrowed_at'],
            'due_at' => $data['due_at'],
            'status' => $data['status'],
            'returned_at' => $data['status'] === 'kembali' ? ($borrowing->returned_at ?? now()->toDateString()) : null,
        ]);

        if ($oldCopy && (! $newCopy || (int) $oldCopy->id !== (int) $newCopy->id)) {
            $oldCopy->update(['status' => 'tersedia']);
        }

        if ($newCopy) {
            $newCopy->update(['status' => $data['status'] === 'aktif' ? 'dipinjam' : 'tersedia']);
        }

        $this->syncBookAvailability((int) $borrowing->book_id);

        return redirect()->route('admin.borrowings.index')->with('success', 'Transaksi peminjaman berhasil diperbarui.');
    }

    public function destroy(Borrowing $borrowing): RedirectResponse
    {
        $bookId = $borrowing->book_id;
        $copy = $borrowing->copy;

        $borrowing->delete();

        if ($copy) {
            $copy->update(['status' => 'tersedia']);
        }

        $this->syncBookAvailability((int) $bookId);

        return redirect()->route('admin.borrowings.index')->with('success', 'Transaksi peminjaman berhasil dihapus.');
    }

    private function syncBookAvailability(int $bookId): void
    {
        $book = Book::query()->find($bookId);

        if (! $book) {
            return;
        }

        $book->update([
            'is_available' => BookCopy::query()->where('book_id', $bookId)->where('status', 'tersedia')->exists(),
        ]);
    }
}
