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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_contract_id');
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('type', ['all_paid', 'rent', 'utility', 'advance'])->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('month_paid')->nullable();
            $table->integer('year_paid')->nullable();
            $table->enum('payment_status',['pending','partial','completed'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->foreign('user_contract_id')->references('id')->on('user_contracts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
