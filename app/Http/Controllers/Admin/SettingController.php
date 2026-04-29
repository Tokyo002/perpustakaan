<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\InteractsWithStaffSession;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'system_logo_file' => ['nullable', 'file', 'image', 'max:4096'],
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

        if ($request->hasFile('system_logo_file')) {
            $this->deleteStoredLogo($setting->system_logo);
            $data['system_logo'] = $this->storeSystemLogo($request->file('system_logo_file'));
        } elseif ($setting->system_logo) {
            $data['system_logo'] = $setting->system_logo;
        }

        unset($data['system_logo_file']);

        $setting->update($data);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }

    private function storeSystemLogo($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('settings/logos', $filename, 'public');

        return 'storage/' . $path;
    }

    private function deleteStoredLogo(?string $path): void
    {
        if (blank($path) || ! str_starts_with($path, 'storage/')) {
            return;
        }

        $relativePath = Str::after($path, 'storage/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
