<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
        Log::info('BookController::store called', ['hasFile' => $request->hasFile('cover_image_file'), 'files' => array_keys($request->files->all())]);

        try {
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
            'cover_image_file' => ['nullable', 'file', 'image', 'max:4096'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('BookController::store validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        if (! empty($data['publisher_id'])) {
            $publisher = Publisher::query()->find($data['publisher_id']);
            $data['publisher'] = $publisher?->name;
        }

        $data['language'] = $data['language'] ?? 'Indonesia';
        $data['stock'] = $data['stock'] ?? 0;
        $data['is_available'] = ($data['stock'] ?? 0) > 0;

        if ($request->hasFile('cover_image_file')) {
            $data['cover_image'] = $this->storeBookCover($request->file('cover_image_file'));
        } else {
            $data['cover_image'] = Book::DEFAULT_COVER_IMAGE;
        }

        unset($data['cover_image_file']);

        if (empty($data['book_code'])) {
            $data['book_code'] = $this->generateBookCode();
        }

        Book::query()->create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        Log::info('BookController::update called', ['book_id' => $book->id, 'hasFile' => $request->hasFile('cover_image_file'), 'files' => array_keys($request->files->all())]);

        try {
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
            'cover_image_file' => ['nullable', 'file', 'image', 'max:4096'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('BookController::update validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        if (! empty($data['publisher_id'])) {
            $publisher = Publisher::query()->find($data['publisher_id']);
            $data['publisher'] = $publisher?->name;
        }

        $data['language'] = $data['language'] ?? 'Indonesia';
        $data['stock'] = $data['stock'] ?? 0;
        $data['is_available'] = ($data['stock'] ?? 0) > 0;

        if ($request->hasFile('cover_image_file')) {
            $this->deleteStoredFile($book->cover_image);
            $data['cover_image'] = $this->storeBookCover($request->file('cover_image_file'));
        } else {
            $data['cover_image'] = $book->cover_image ?: Book::DEFAULT_COVER_IMAGE;
        }

        unset($data['cover_image_file']);

        if (empty($data['book_code'])) {
            $data['book_code'] = $book->book_code ?: $this->generateBookCode();
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $this->deleteStoredFile($book->cover_image);
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function storeBookCover($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        try {
            $path = $file->storeAs('books/covers', $filename, 'public');
            Log::info('storeBookCover: attempted storeAs', ['path' => $path, 'filename' => $filename]);

            if ($path && Storage::disk('public')->exists($path)) {
                return 'storage/' . $path;
            }

            // Fallback: try putFileAs directly on the disk
            $fallback = Storage::disk('public')->putFileAs('books/covers', $file, $filename);
            Log::info('storeBookCover: fallback putFileAs result', ['result' => $fallback]);

            if ($fallback) {
                return 'storage/' . ltrim($fallback, '/');
            }

            Log::warning('storeBookCover: failed to store file, returning default cover', ['filename' => $filename]);
            return Book::DEFAULT_COVER_IMAGE;
        } catch (\Throwable $e) {
            Log::error('storeBookCover error', ['message' => $e->getMessage()]);
            return Book::DEFAULT_COVER_IMAGE;
        }
    }

    private function deleteStoredFile(?string $path): void
    {
        if (blank($path) || $path === Book::DEFAULT_COVER_IMAGE || ! str_starts_with($path, 'storage/')) {
            return;
        }

        $relativePath = Str::after($path, 'storage/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function generateBookCode(): string
    {
        $lastBookId = (int) (Book::query()->max('id') ?? 0);
        $nextSequence = str_pad((string) ($lastBookId + 1), 4, '0', STR_PAD_LEFT);

        return 'BKU-' . $nextSequence;
    }
}
