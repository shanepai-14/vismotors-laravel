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
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->string('or_number')->unique();
            $table->string('ref_no');
            $table->unsignedBigInteger('transaction_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->unsignedBigInteger('cashier_id')->unique();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_method')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->dropColumn(['ref_no','transaction_id','amount','cashier_id','status','or_number','payment_method',]);
        });
    }
};
