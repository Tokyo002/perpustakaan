<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'media_url' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

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
            'media_url' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $item->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(GalleryItem $item): RedirectResponse
    {
        $item->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
