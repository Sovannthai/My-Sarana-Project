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
        Schema::create('price_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->decimal('percentage', 5, 2);
            $table->text('description')->nullable();
<<<<<<< HEAD:database/migrations/2024_11_28_111933_create_price_adjustments_table.php
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['long_term', 'seasonal', 'prepayment'])->nullable();
            $table->integer('min_months')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('min_prepayment_months')->nullable();
=======
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
>>>>>>> pheakdey_branch:database/migrations/2024_09_10_124500_create_price_adjustments_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_adjustments');
    }
};
