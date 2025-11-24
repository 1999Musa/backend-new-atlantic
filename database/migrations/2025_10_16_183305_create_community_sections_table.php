<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('community_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'hero', 'employees', 'gallery'
            $table->json('images')->nullable(); // store one or multiple image paths
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_sections');
    }
};
