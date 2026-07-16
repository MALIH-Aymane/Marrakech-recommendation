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
        Schema::table('attractions', function (Blueprint $table) {

            $table->text('languages')->nullable()->after('reviews_url');

            $table->text('location_img')->nullable()->after('languages');

            $table->longText('ratings_list')->nullable()->after('location_img');

            $table->string('type')->nullable()->after('ratings_list');

            $table->decimal('latitude', 10, 7)->nullable()->after('type');

            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attractions', function (Blueprint $table) {

            $table->dropColumn([
                'languages',
                'location_img',
                'ratings_list',
                'type',
                'latitude',
                'longitude'
            ]);

        });
    }
};