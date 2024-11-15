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
            $table->decimal('percentage', 5, 2); // Store percentage value, for example 10.00 for 10%
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status column to mark if adjustment is active or not

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_adjustments');
    }
}
