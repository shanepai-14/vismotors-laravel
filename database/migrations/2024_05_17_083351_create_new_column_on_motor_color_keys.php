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
        Schema::table('motor_color_keys', function (Blueprint $table) {
            $table->unsignedBigInteger('motor_type_id')->nullable()->after('color');
            $table->foreign('motor_type_id')->references('id')->on('motor_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motor_color_keys', function (Blueprint $table) {
            $table->dropColumn('motor_type_id');
        });
    }
};
