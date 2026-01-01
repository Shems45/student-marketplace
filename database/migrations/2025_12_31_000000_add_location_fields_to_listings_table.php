<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('location_city', 80)->nullable()->after('is_sold');
            $table->string('location_zip', 12)->nullable()->after('location_city');
            $table->decimal('lat', 10, 7)->nullable()->after('location_zip');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');

            $table->index('lat');
            $table->index('lng');
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropIndex(['lat']);
            $table->dropIndex(['lng']);
            $table->dropColumn(['location_city', 'location_zip', 'lat', 'lng']);
        });
    }
};
