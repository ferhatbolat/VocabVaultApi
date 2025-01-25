<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'turkish',
        'english',
        'learning_status',
    ];

    protected $casts = [
        'learning_status' => 'integer',
    ];
}
