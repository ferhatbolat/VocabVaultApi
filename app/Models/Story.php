<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'title',
        'content',
        'current_page',
    ];

    protected $casts = [
        'current_page' => 'integer',
    ];
}
