<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    use InteractsWithStaffSession;

    public function index(Request $request): View
    {
        $setting = AppSetting::query()->firstOrCreate([], [
            'system_name' => 'Sistem Informasi Perpustakaan',
            'fine_per_day' => 2000,
            'loan_duration_days' => 7,
        ]);

        return view('admin.settings.index', [
            'setting' => $setting,
            'staff' => $this->currentStaff($request),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'system_name' => ['required', 'string', 'max:150'],
            'system_logo' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'fine_per_day' => ['required', 'numeric', 'min:0'],
            'loan_duration_days' => ['required', 'integer', 'min:1', 'max:90'],
        ]);

        $setting = AppSetting::query()->firstOrCreate([], [
            'system_name' => 'Sistem Informasi Perpustakaan',
            'fine_per_day' => 2000,
            'loan_duration_days' => 7,
        ]);

        $data['updated_by_staff_id'] = $this->currentStaffId($request);

        $setting->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
