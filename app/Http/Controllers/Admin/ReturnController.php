<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\AppSetting;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\ReturnRecord;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $returns = ReturnRecord::query()
            ->with(['borrowing.member', 'borrowing.book'])
            ->latest()
            ->get();

        $editReturn = null;

        if ($request->filled('edit')) {
            $editReturn = ReturnRecord::query()->find($request->integer('edit'));
        }

        return view('admin.returns.index', [
            'returns' => $returns,
            'activeBorrowings' => Borrowing::query()->with(['member', 'book'])->where('status', 'aktif')->latest()->get(),
            'editReturn' => $editReturn,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'borrowing_id' => ['required', 'exists:borrowings,id'],
            'returned_at' => ['required', 'date'],
            'book_condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
        ]);

        $borrowing = Borrowing::query()->with(['member', 'book', 'copy'])->findOrFail($data['borrowing_id']);
        $returnedAt = Carbon::parse($data['returned_at']);
        $dueDate = Carbon::parse($borrowing->due_at);
        $lateDays = max(0, (int) $dueDate->diffInDays($returnedAt, false));

        $returnRecord = ReturnRecord::query()->updateOrCreate(
            ['borrowing_id' => $borrowing->id],
            [
                'member_id' => $borrowing->member_id,
                'book_id' => $borrowing->book_id,
                'staff_user_id' => $this->currentStaffId($request),
                'due_date' => $borrowing->due_at,
                'returned_at' => $returnedAt->toDateString(),
                'book_condition' => $data['book_condition'],
                'late_days' => $lateDays,
            ],
        );

        $borrowing->update([
            'status' => 'kembali',
            'returned_at' => $returnedAt->toDateString(),
        ]);

        if ($borrowing->copy) {
            $borrowing->copy->update(['status' => 'tersedia']);
        }

        $this->syncBookAvailability((int) $borrowing->book_id);
        $this->syncFineFromReturn($borrowing, $returnRecord, $lateDays);

        return redirect()->route('admin.returns.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    public function update(Request $request, ReturnRecord $return): RedirectResponse
    {
        $data = $request->validate([
            'returned_at' => ['required', 'date'],
            'book_condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
        ]);

        $dueDate = Carbon::parse($return->due_date);
        $returnedAt = Carbon::parse($data['returned_at']);
        $lateDays = max(0, (int) $dueDate->diffInDays($returnedAt, false));

        $return->update([
            'returned_at' => $returnedAt->toDateString(),
            'book_condition' => $data['book_condition'],
            'late_days' => $lateDays,
            'staff_user_id' => $this->currentStaffId($request),
        ]);

        if ($return->borrowing) {
            $return->borrowing->update([
                'status' => 'kembali',
                'returned_at' => $returnedAt->toDateString(),
            ]);

            $this->syncFineFromReturn($return->borrowing, $return, $lateDays);
        }

        return redirect()->route('admin.returns.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(ReturnRecord $return): RedirectResponse
    {
        $borrowing = $return->borrowing;
        $bookId = $return->book_id;

        Fine::query()->where('return_record_id', $return->id)->delete();
        $return->delete();

        if ($borrowing) {
            $borrowing->update([
                'status' => 'aktif',
                'returned_at' => null,
            ]);

            if ($borrowing->copy) {
                $borrowing->copy->update(['status' => 'dipinjam']);
            }
        }

        $this->syncBookAvailability((int) $bookId);

        return redirect()->route('admin.returns.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }

    private function syncFineFromReturn(Borrowing $borrowing, ReturnRecord $returnRecord, int $lateDays): void
    {
        $finePerDay = (float) (AppSetting::query()->first()->fine_per_day ?? 2000);
        $amount = max(0, $lateDays * $finePerDay);

        if ($amount <= 0) {
            Fine::query()->where('return_record_id', $returnRecord->id)->delete();

            return;
        }

        Fine::query()->updateOrCreate(
            ['return_record_id' => $returnRecord->id],
            [
                'member_id' => $borrowing->member_id,
                'book_id' => $borrowing->book_id,
                'borrowing_id' => $borrowing->id,
                'fine_type' => 'keterlambatan',
                'late_days' => $lateDays,
                'amount' => $amount,
                'paid_amount' => 0,
                'remaining_amount' => $amount,
                'payment_status' => 'belum_dibayar',
            ],
        );
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
