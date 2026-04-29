<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $staff = $this->currentStaff($request);

        abort_unless($staff, 403);

        return view('admin.profile.index', [
            'staff' => $staff,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $staff = $this->currentStaff($request);

        abort_unless($staff, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'regex:/@gmail\\.com$/i', 'unique:staff_users,email,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'email.regex' => 'Email profil admin/petugas harus Gmail.',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $staff->update($data);

        $request->session()->put('staff_user_name', $staff->name);

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
