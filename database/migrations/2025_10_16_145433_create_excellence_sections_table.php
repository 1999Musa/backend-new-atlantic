<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('excellence_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->json('images')->nullable();
            $table->timestamps();
        });

        // Optionally, seed default sections
        DB::table('excellence_sections')->insert([
            ['title' => 'Store & Kanban', 'images' => json_encode([]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sample', 'images' => json_encode([]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cutting', 'images' => json_encode([]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Production', 'images' => json_encode([]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Inspection & Finishing', 'images' => json_encode([]), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('excellence_sections');
    }
};
