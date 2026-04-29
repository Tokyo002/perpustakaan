<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookCopyController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $copies = BookCopy::query()->with('book')->latest()->get();
        $books = Book::query()->orderBy('title')->get();
        $editCopy = null;

        if ($request->filled('edit')) {
            $editCopy = BookCopy::query()->find($request->integer('edit'));
        }

        return view('admin.copies.index', [
            'copies' => $copies,
            'books' => $books,
            'editCopy' => $editCopy,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'copy_code' => ['required', 'string', 'max:100', 'unique:book_copies,copy_code'],
            'quantity' => ['required', 'integer', 'min:1'],
            'rack_location' => ['nullable', 'string', 'max:120'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'status' => ['required', 'in:tersedia,dipinjam'],
        ]);

        $copy = BookCopy::query()->create($data);
        $this->syncBookInventory((int) $copy->book_id);

        return redirect()->route('admin.copies.index')->with('success', 'Eksemplar buku berhasil ditambahkan.');
    }

    public function update(Request $request, BookCopy $copy): RedirectResponse
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'copy_code' => ['required', 'string', 'max:100', 'unique:book_copies,copy_code,' . $copy->id],
            'quantity' => ['required', 'integer', 'min:1'],
            'rack_location' => ['nullable', 'string', 'max:120'],
            'condition' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'status' => ['required', 'in:tersedia,dipinjam'],
        ]);

        $oldBookId = $copy->book_id;
        $copy->update($data);

        $this->syncBookInventory((int) $oldBookId);

        if ((int) $oldBookId !== (int) $copy->book_id) {
            $this->syncBookInventory((int) $copy->book_id);
        }

        return redirect()->route('admin.copies.index')->with('success', 'Eksemplar buku berhasil diperbarui.');
    }

    public function destroy(BookCopy $copy): RedirectResponse
    {
        $bookId = $copy->book_id;
        $copy->delete();
        $this->syncBookInventory((int) $bookId);

        return redirect()->route('admin.copies.index')->with('success', 'Eksemplar buku berhasil dihapus.');
    }

    private function syncBookInventory(int $bookId): void
    {
        $book = Book::query()->find($bookId);

        if (! $book) {
            return;
        }

        $stock = (int) BookCopy::query()->where('book_id', $bookId)->sum('quantity');
        $isAvailable = BookCopy::query()
            ->where('book_id', $bookId)
            ->where('status', 'tersedia')
            ->exists();

        $book->update([
            'stock' => $stock,
            'is_available' => $isAvailable,
        ]);
    }
}
