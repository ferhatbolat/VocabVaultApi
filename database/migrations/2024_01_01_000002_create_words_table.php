<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
      {
            Schema::create('words', function (Blueprint $table) {
                  $table->id();
                  $table->string('turkish');
                  $table->string('english');
                  $table->tinyInteger('learning_status')->default(0);
                  $table->timestamps();
                  $table->softDeletes();
            });
      }

      public function down()
      {
            Schema::dropIfExists('words');
      }
};
