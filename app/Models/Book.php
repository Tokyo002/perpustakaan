<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_code',
        'category_id',
        'publisher_id',
        'title',
        'author',
        'publisher',
        'published_year',
        'isbn',
        'language',
        'genre',
        'abstract',
        'cover_image',
        'is_available',
        'stock',
    ];

    public const DEFAULT_COVER_IMAGE = 'template/img/buku.jpg';

    protected static function booted(): void
    {
        static::saving(function (Book $book): void {
            if (blank($book->cover_image)) {
                $book->cover_image = self::DEFAULT_COVER_IMAGE;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'published_year' => 'integer',
            'stock' => 'integer',
        ];
    }

    protected function coverImage(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?: self::DEFAULT_COVER_IMAGE,
            set: fn (?string $value) => blank($value) ? self::DEFAULT_COVER_IMAGE : $value,
        );
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): string {
                $coverImage = $attributes['cover_image'] ?? self::DEFAULT_COVER_IMAGE;

                if (blank($coverImage)) {
                    return '/' . ltrim(self::DEFAULT_COVER_IMAGE, '/');
                }

                if (Str::startsWith($coverImage, ['http://', 'https://'])) {
                    return $coverImage;
                }

                if (Str::startsWith($coverImage, 'storage/')) {
                    $relativePath = Str::after($coverImage, 'storage/');

                    if (! Storage::disk('public')->exists($relativePath)) {
                        return '/' . ltrim(self::DEFAULT_COVER_IMAGE, '/');
                    }

                    return '/' . ltrim($coverImage, '/');
                }

                return '/' . ltrim($coverImage, '/');
            }
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function publisherModel(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function copies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }
}
