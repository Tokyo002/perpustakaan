<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'topic',
        'year',
        'abstract',
        'access_level',
        'resource_type',
        'resource_url',
    ];
}
