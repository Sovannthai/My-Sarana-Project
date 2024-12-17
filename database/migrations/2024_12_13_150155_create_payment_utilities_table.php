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
        Schema::create('payment_utilities', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->integer('utility_id');
            $table->integer('usage')->default(0);
            $table->decimal('rate_per_unit',10,2)->default(0);
            $table->decimal('total_amount',10,2)->default(0);
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
        Schema::dropIfExists('payment_utilities');
    }
};
