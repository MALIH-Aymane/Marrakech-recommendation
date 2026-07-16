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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate', 3, 2)->nullable();
            $table->string('attraction');
            $table->longText('reviews')->nullable();
            $table->longText('details')->nullable();
            $table->text('attraction_url')->nullable();
            $table->text('reviews_url')->nullable();
            $table->string('uuid')->unique();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
