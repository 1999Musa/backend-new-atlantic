<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('hero_image')->nullable(); // main image
            $table->json('images')->nullable(); // multiple images
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};
