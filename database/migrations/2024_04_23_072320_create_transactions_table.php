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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->unsignedBigInteger('trans_type_id');
            $table->foreign('trans_type_id')->references('id')->on('transaction_types');
            $table->unsignedBigInteger('motor_id');
            $table->foreign('motor_id')->references('id')->on('motor_color_keys');
            $table->float('downpayment')->default(0);
            $table->float('monthly_due')->default(0);
            $table->integer('loan_tenure_months')->default(0);
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
