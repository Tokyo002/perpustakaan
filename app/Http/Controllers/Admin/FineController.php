<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FineController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $fines = Fine::query()->with(['member', 'book'])->latest()->get();
        $editFine = null;

        if ($request->filled('edit')) {
            $editFine = Fine::query()->find($request->integer('edit'));
        }

        return view('admin.fines.index', [
            'fines' => $fines,
            'members' => Member::query()->orderBy('name')->get(),
            'books' => Book::query()->orderBy('title')->get(),
            'editFine' => $editFine,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => ['required', 'exists:books,id'],
            'fine_type' => ['required', 'string', 'max:100'],
            'late_days' => ['nullable', 'integer', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['late_days'] = (int) ($data['late_days'] ?? 0);
        $data['paid_amount'] = (float) ($data['paid_amount'] ?? 0);
        $data['remaining_amount'] = max(0, (float) $data['amount'] - (float) $data['paid_amount']);
        $data['payment_status'] = $this->resolvePaymentStatus((float) $data['amount'], (float) $data['paid_amount']);

        Fine::query()->create($data);

        return redirect()->route('admin.fines.index')->with('success', 'Data denda berhasil ditambahkan.');
    }

    public function update(Request $request, Fine $fine): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'book_id' => ['required', 'exists:books,id'],
            'fine_type' => ['required', 'string', 'max:100'],
            'late_days' => ['nullable', 'integer', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['late_days'] = (int) ($data['late_days'] ?? 0);
        $data['paid_amount'] = (float) ($data['paid_amount'] ?? 0);
        $data['remaining_amount'] = max(0, (float) $data['amount'] - (float) $data['paid_amount']);
        $data['payment_status'] = $this->resolvePaymentStatus((float) $data['amount'], (float) $data['paid_amount']);

        $fine->update($data);

        return redirect()->route('admin.fines.index')->with('success', 'Data denda berhasil diperbarui.');
    }

    public function destroy(Fine $fine): RedirectResponse
    {
        $fine->delete();

        return redirect()->route('admin.fines.index')->with('success', 'Data denda berhasil dihapus.');
    }

    private function resolvePaymentStatus(float $amount, float $paidAmount): string
    {
        if ($paidAmount <= 0) {
            return 'belum_dibayar';
        }

        if ($paidAmount >= $amount) {
            return 'dibayar';
        }

        return 'sebagian';
    }
}
