<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('swatch_requests', function (Blueprint $table) {
        $table->id();
        // Add this line to link to products table
        $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null'); 
        
        $table->string('name');
        $table->string('email');
        $table->string('phone_country')->default('+91');
        $table->string('phone_number');
        $table->text('address');
        $table->text('message');
        $table->string('status')->default('pending'); // Add status column if missing
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('swatch_requests');
    }
};
