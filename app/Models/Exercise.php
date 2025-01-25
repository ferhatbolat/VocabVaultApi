<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
      use HasFactory, SoftDeletes;

      protected $fillable = [
            'word_id',
            'type',
            'question',
            'options',
            'correct_answer'
      ];

      protected $casts = [
            'options' => 'array'
      ];

      public function word()
      {
            return $this->belongsTo(Word::class);
      }
}
