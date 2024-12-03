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
            $table->foreignId('user_contract_id')->constrained('user_contracts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['all_paid', 'rent', 'utility', 'advance']);
            $table->date('payment_date');
            $table->integer('month_paid')->nullable();
            $table->integer('year_paid')->nullable();
            $table->timestamps();
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
