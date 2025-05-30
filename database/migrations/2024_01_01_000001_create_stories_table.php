<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
      {
            Schema::create('stories', function (Blueprint $table) {
                  $table->id();
                  $table->string('title');
                  $table->text('content');
                  $table->integer('current_page')->default(0);
                  $table->timestamps();
                  $table->softDeletes();
            });
      }

      public function down()
      {
            Schema::dropIfExists('stories');
      }
};
