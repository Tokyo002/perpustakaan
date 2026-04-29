<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DigitalResourceController extends Controller
{
    public function index(): View
    {
        $resources = DigitalResource::query()->orderByDesc('year')->orderBy('title')->paginate(15);

        return view('admin.digital-resources.index', compact('resources'));
    }

    public function create(): View
    {
        return view('admin.digital-resources.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'between:1900,2100'],
            'abstract' => ['nullable', 'string'],
            'access_level' => ['required', 'string', 'in:open,limited'],
            'resource_type' => ['required', 'string', 'in:pdf,link'],
            'resource_url' => ['nullable', 'string', 'max:255'],
        ]);

        DigitalResource::query()->create($validated);

        return redirect()->route('admin.digital-resources.index')->with('success', 'Artikel/Jurnal berhasil ditambahkan.');
    }

    public function edit(DigitalResource $digitalResource): View
    {
        return view('admin.digital-resources.edit', ['resource' => $digitalResource]);
    }

    public function update(Request $request, DigitalResource $digitalResource): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'between:1900,2100'],
            'abstract' => ['nullable', 'string'],
            'access_level' => ['required', 'string', 'in:open,limited'],
            'resource_type' => ['required', 'string', 'in:pdf,link'],
            'resource_url' => ['nullable', 'string', 'max:255'],
        ]);

        $digitalResource->update($validated);

        return redirect()->route('admin.digital-resources.index')->with('success', 'Artikel/Jurnal berhasil diperbarui.');
    }

    public function destroy(DigitalResource $digitalResource): RedirectResponse
    {
        $digitalResource->delete();

        return redirect()->route('admin.digital-resources.index')->with('success', 'Artikel/Jurnal berhasil dihapus.');
    }
}
