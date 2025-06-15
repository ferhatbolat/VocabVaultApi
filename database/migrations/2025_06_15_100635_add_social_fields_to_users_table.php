<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email'); // google, facebook, apple
            $table->string('provider_id')->nullable()->after('provider'); // sosyal medya platform ID'si
            $table->string('avatar')->nullable()->after('provider_id'); // profil resmi URL'si
            $table->timestamp('email_verified_at')->nullable()->change(); // email doğrulama opsiyonel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_id', 'avatar']);
        });
    }
};
