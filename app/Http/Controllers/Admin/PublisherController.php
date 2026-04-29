<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublisherController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $publishers = Publisher::query()->withCount('books')->orderBy('name')->get();
        $editPublisher = null;

        if ($request->filled('edit')) {
            $editPublisher = Publisher::query()->find($request->integer('edit'));
        }

        return view('admin.publishers.index', [
            'publishers' => $publishers,
            'editPublisher' => $editPublisher,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:publishers,name'],
            'address' => ['nullable', 'string', 'max:1000'],
            'contact' => ['nullable', 'string', 'max:50'],
        ]);

        Publisher::query()->create($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function update(Request $request, Publisher $publisher): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:publishers,name,' . $publisher->id],
            'address' => ['nullable', 'string', 'max:1000'],
            'contact' => ['nullable', 'string', 'max:50'],
        ]);

        $publisher->update($data);

        return redirect()->route('admin.publishers.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
