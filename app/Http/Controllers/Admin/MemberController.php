<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $members = Member::query()->latest()->get();
        $editMember = null;

        if ($request->filled('edit')) {
            $editMember = Member::query()->find($request->integer('edit'));
        }

        return view('admin.members.index', [
            'members' => $members,
            'editMember' => $editMember,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'member_number' => ['required', 'string', 'max:50', 'unique:members,member_number'],
            'name' => ['required', 'string', 'max:150'],
            'member_type' => ['required', 'in:siswa,guru'],
            'class_or_position' => ['nullable', 'string', 'max:50'],
            'contact' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        Member::query()->create($data);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $data = $request->validate([
            'member_number' => ['required', 'string', 'max:50', 'unique:members,member_number,' . $member->id],
            'name' => ['required', 'string', 'max:150'],
            'member_type' => ['required', 'in:siswa,guru'],
            'class_or_position' => ['nullable', 'string', 'max:50'],
            'contact' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $member->update($data);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
