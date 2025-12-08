<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user_logins')
                ->nullOnDelete()
                ->after('id');
        });

        Schema::table('swatch_requests', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user_logins')
                ->nullOnDelete()
                ->after('id');
        });
    }

    public function down()
    {
        Schema::table('custom_requests', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('swatch_requests', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
