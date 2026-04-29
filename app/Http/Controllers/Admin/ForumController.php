<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(): View
    {
        $posts = ForumPost::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.forum.index', compact('posts'));
    }

    public function edit(ForumPost $post): View
    {
        return view('admin.forum.edit', compact('post'));
    }

    public function update(Request $request, ForumPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'topic' => ['nullable', 'string', 'max:100'],
            'is_recommendation' => ['nullable', 'boolean'],
        ]);

        $post->update($validated);

        return redirect()->route('admin.forum.index')->with('success', 'Post forum berhasil diperbarui.');
    }

    public function destroy(ForumPost $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('admin.forum.index')->with('success', 'Post forum berhasil dihapus.');
    }
}
