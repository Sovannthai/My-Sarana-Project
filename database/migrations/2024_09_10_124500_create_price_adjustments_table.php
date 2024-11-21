<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceAdjustmentsTable extends Migration
{
    public function up()
    {
        Schema::create('price_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->decimal('percentage', 5, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['long_term', 'seasonal', 'prepayment'])->nullable();

            // For long-term discounts, you can specify the minimum number of months
            $table->integer('min_months')->nullable(); // Applicable for long-term rentals

            // For seasonal discounts, add start and end dates to specify the season
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // For prepayment discounts, you can specify the minimum months to be prepaid
            $table->integer('min_prepayment_months')->nullable(); // Applicable for prepayment discounts

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_adjustments');
    }
}
