<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $items = GalleryItem::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'media_type' => ['required', 'string', 'in:image,video'],
            'media_file' => ['required', 'file', 'max:51200'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $this->ensureMediaFileMatchesType($request);

        $validated['media_url'] = $this->storeGalleryMedia($request->file('media_file'));
        unset($validated['media_file']);

        GalleryItem::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(GalleryItem $item): View
    {
        return view('admin.gallery.edit', compact('item'));
    }

    public function update(Request $request, GalleryItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'media_type' => ['required', 'string', 'in:image,video'],
            'media_file' => ['nullable', 'file', 'max:51200'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $this->ensureMediaFileMatchesType($request);

        if ($request->hasFile('media_file')) {
            $this->deleteStoredMedia($item->media_url);
            $validated['media_url'] = $this->storeGalleryMedia($request->file('media_file'));
        } else {
            $validated['media_url'] = $item->media_url;
        }

        unset($validated['media_file']);

        $item->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(GalleryItem $item): RedirectResponse
    {
        $this->deleteStoredMedia($item->media_url);
        $item->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus.');
    }

    private function storeGalleryMedia($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $folder = $this->isVideoExtension($extension) ? 'gallery/videos' : 'gallery/images';
        $filename = Str::uuid() . '.' . $extension;
        $path = $file->storeAs($folder, $filename, 'public');

        return 'storage/' . $path;
    }

    private function deleteStoredMedia(?string $path): void
    {
        if (blank($path) || ! str_starts_with($path, 'storage/')) {
            return;
        }

        $relativePath = Str::after($path, 'storage/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function isVideoExtension(string $extension): bool
    {
        return in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'm4v'], true);
    }

    private function ensureMediaFileMatchesType(Request $request): void
    {
        if (! $request->hasFile('media_file')) {
            return;
        }

        $file = $request->file('media_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType() ?: '';

        if ($request->string('media_type')->toString() === 'image' && ! str_starts_with($mimeType, 'image/')) {
            throw ValidationException::withMessages([
                'media_file' => 'Untuk media gambar, gunakan file image yang valid.',
            ]);
        }

        if ($request->string('media_type')->toString() === 'video' && ! str_starts_with($mimeType, 'video/') && ! $this->isVideoExtension($extension)) {
            throw ValidationException::withMessages([
                'media_file' => 'Untuk media video, gunakan file MP4, WebM, OGG, MOV, atau M4V.',
            ]);
        }
    }
}
