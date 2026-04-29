<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'system_logo',
        'phone',
        'address',
        'fine_per_day',
        'loan_duration_days',
        'updated_by_staff_id',
    ];

    protected function casts(): array
    {
        return [
            'fine_per_day' => 'float',
            'loan_duration_days' => 'integer',
        ];
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(StaffUser::class, 'updated_by_staff_id');
    }
}
