<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('swatch_requests', function (Blueprint $table) {
        $table->string('product_code')->nullable()->after('product_id');
        $table->string('product_name')->nullable()->after('product_code');
    });

    Schema::table('custom_requests', function (Blueprint $table) {
        $table->string('product_code')->nullable()->after('product_id');
        $table->string('product_name')->nullable()->after('product_code');
    });
}

public function down()
{
    Schema::table('swatch_requests', function (Blueprint $table) {
        $table->dropColumn(['product_code', 'product_name']);
    });

    Schema::table('custom_requests', function (Blueprint $table) {
        $table->dropColumn(['product_code', 'product_name']);
    });
}

};
