<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('swatch_requests', function (Blueprint $table) {
            $table->string('product_code')->nullable()->after('id');
            $table->enum('status', ['pending', 'approved', 'delivered'])->default('pending')->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('swatch_requests', function (Blueprint $table) {
            $table->dropColumn(['product_code', 'status']);
        });
    }
};