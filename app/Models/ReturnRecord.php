<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class ReturnRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'member_id',
        'book_id',
        'staff_user_id',
        'due_date',
        'returned_at',
        'book_condition',
        'late_days',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'returned_at' => 'date',
            'late_days' => 'integer',
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(StaffUser::class, 'staff_user_id');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }
}
