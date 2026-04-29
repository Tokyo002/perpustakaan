<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $summary = [
            'total_books' => Book::query()->count(),
            'active_members' => Member::query()->where('is_active', true)->count(),
            'active_borrowings' => Borrowing::query()->where('status', 'aktif')->count(),
            'outstanding_fines' => (float) Fine::query()->whereIn('payment_status', ['belum_dibayar', 'sebagian'])->sum('remaining_amount'),
        ];

        $latestBorrowings = Borrowing::query()
            ->with(['member', 'book'])
            ->latest()
            ->take(6)
            ->get();

        $latestFines = Fine::query()
            ->with(['member', 'book'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'summary' => $summary,
            'latestBorrowings' => $latestBorrowings,
            'latestFines' => $latestFines,
            'staff' => $this->currentStaff($request),
        ]);
    }
}
