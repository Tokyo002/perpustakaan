<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'borrowing_id',
        'return_record_id',
        'fine_type',
        'late_days',
        'amount',
        'paid_amount',
        'remaining_amount',
        'payment_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'late_days' => 'integer',
            'amount' => 'float',
            'paid_amount' => 'float',
            'remaining_amount' => 'float',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function returnRecord(): BelongsTo
    {
        return $this->belongsTo(ReturnRecord::class);
    }
}
