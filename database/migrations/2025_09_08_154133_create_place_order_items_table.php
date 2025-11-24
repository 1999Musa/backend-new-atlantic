<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('place_order_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['step', 'info', 'reason']); // distinguish section
            $table->string('step')->nullable(); // for steps (01,02,...)
            $table->string('title');            // required
            $table->text('description')->nullable(); // optional
            $table->json('list_items')->nullable();  // for info lists
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('place_order_items');
    }
};
