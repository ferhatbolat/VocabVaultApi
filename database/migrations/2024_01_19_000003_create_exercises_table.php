<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
      {
            Schema::create('exercises', function (Blueprint $table) {
                  $table->id();
                  $table->foreignId('word_id')->constrained()->onDelete('cascade');
                  $table->string('type');
                  $table->string('question');
                  $table->json('options');
                  $table->string('correct_answer');
                  $table->timestamps();
                  $table->softDeletes();
            });
      }

      public function down()
      {
            Schema::dropIfExists('exercises');
      }
};
