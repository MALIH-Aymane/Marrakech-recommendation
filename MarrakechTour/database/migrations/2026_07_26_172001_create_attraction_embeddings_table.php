<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attraction_embeddings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('attraction_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->longText('embedding');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attraction_embeddings');
    }
};