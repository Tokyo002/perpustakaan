<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'regex:/@gmail\\.com$/i'],
            'password' => ['required', 'string'],
        ], [
            'email.regex' => 'Gunakan akun Gmail untuk login admin.',
        ]);

        $staff = StaffUser::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($credentials['email'])])
            ->first();

        if (! $staff || ! Hash::check($credentials['password'], $staff->password)) {
            return back()->withInput()->with('error', 'Email atau sandi salah.');
        }

        if (! $staff->is_active) {
            return back()->withInput()->with('error', 'Akun admin dinonaktifkan.');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'staff_user_id' => $staff->id,
            'staff_user_name' => $staff->name,
            'staff_user_role' => $staff->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil. Selamat datang.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['staff_user_id', 'staff_user_name', 'staff_user_role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda berhasil logout.');
    }
}
