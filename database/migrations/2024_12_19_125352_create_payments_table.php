<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key, bigint
            $table->unsignedBigInteger('user_contract_id')->nullable();
            $table->decimal('total_amount', 8, 2)->default(0.00);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('total_due_amount', 8, 2)->default(0.00);
            $table->enum('type', ['all_paid', 'rent', 'utility', 'advance'])->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('month_paid')->nullable();
            $table->integer('year_paid')->nullable();
            $table->enum('payment_status', ['completed', 'pending', 'partial'])->nullable();
            $table->timestamps();
            $table->decimal('room_price', 10, 2)->default(0.00);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('total_discount', 10, 2)->default(0.00);
            $table->enum('discount_type', ['amount', 'percentage'])->nullable();
            $table->decimal('total_amount_amenity', 10, 2)->default(0.00);
            $table->decimal('total_utility_amount', 10, 2)->default(0.00);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
