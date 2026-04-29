<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $books = Book::query()
            ->with(['category', 'publisherModel'])
            ->withCount('copies')
            ->orderBy('title')
            ->get();

        $editBook = null;

        if ($request->filled('edit')) {
            $editBook = Book::query()->find($request->integer('edit'));
        }

        return view('admin.books.index', [
            'books' => $books,
            'categories' => Category::query()->orderBy('name')->get(),
            'publishers' => Publisher::query()->orderBy('name')->get(),
            'editBook' => $editBook,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_code' => ['nullable', 'string', 'max:50', 'unique:books,book_code'],
            'title' => ['required', 'string', 'max:200'],
            'author' => ['required', 'string', 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
            'published_year' => ['nullable', 'integer', 'between:1900,2100'],
            'isbn' => ['nullable', 'string', 'max:30', 'unique:books,isbn'],
            'language' => ['nullable', 'string', 'max:50'],
            'genre' => ['nullable', 'string', 'max:120'],
            'abstract' => ['nullable', 'string', 'max:5000'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        if (! empty($data['publisher_id'])) {
            $publisher = Publisher::query()->find($data['publisher_id']);
            $data['publisher'] = $publisher?->name;
        }

        $data['language'] = $data['language'] ?? 'Indonesia';
        $data['stock'] = $data['stock'] ?? 0;
        $data['is_available'] = ($data['stock'] ?? 0) > 0;
        $data['cover_image'] = $data['cover_image'] ?? Book::DEFAULT_COVER_IMAGE;

        if (empty($data['book_code'])) {
            $data['book_code'] = $this->generateBookCode();
        }

        Book::query()->create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'book_code' => ['nullable', 'string', 'max:50', 'unique:books,book_code,' . $book->id],
            'title' => ['required', 'string', 'max:200'],
            'author' => ['required', 'string', 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
            'published_year' => ['nullable', 'integer', 'between:1900,2100'],
            'isbn' => ['nullable', 'string', 'max:30', 'unique:books,isbn,' . $book->id],
            'language' => ['nullable', 'string', 'max:50'],
            'genre' => ['nullable', 'string', 'max:120'],
            'abstract' => ['nullable', 'string', 'max:5000'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        if (! empty($data['publisher_id'])) {
            $publisher = Publisher::query()->find($data['publisher_id']);
            $data['publisher'] = $publisher?->name;
        }

        $data['language'] = $data['language'] ?? 'Indonesia';
        $data['stock'] = $data['stock'] ?? 0;
        $data['is_available'] = ($data['stock'] ?? 0) > 0;
        $data['cover_image'] = $data['cover_image'] ?? Book::DEFAULT_COVER_IMAGE;

        if (empty($data['book_code'])) {
            $data['book_code'] = $book->book_code ?: $this->generateBookCode();
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function generateBookCode(): string
    {
        $lastBookId = (int) (Book::query()->max('id') ?? 0);
        $nextSequence = str_pad((string) ($lastBookId + 1), 4, '0', STR_PAD_LEFT);

        return 'BKU-' . $nextSequence;
    }
}
