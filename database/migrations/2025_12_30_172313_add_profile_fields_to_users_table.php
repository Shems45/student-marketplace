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
            $table->boolean('is_admin')->default(false)->after('password');

            $table->string('username')->unique()->after('email');
            $table->date('birthday')->nullable()->after('username');
            $table->string('profile_photo_path')->nullable()->after('birthday');
            $table->text('bio')->nullable()->after('profile_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'username', 'birthday', 'profile_photo_path', 'bio']);
        });
    }
};
