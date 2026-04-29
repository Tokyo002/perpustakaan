<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\StaffUser;
use Illuminate\Http\Request;

trait InteractsWithStaffSession
{
    protected function currentStaffId(Request $request): ?int
    {
        return $request->session()->get('staff_user_id');
    }

    protected function currentStaff(Request $request): ?StaffUser
    {
        $staffId = $this->currentStaffId($request);

        if (! $staffId) {
            return null;
        }

        return StaffUser::query()->find($staffId);
    }
}
