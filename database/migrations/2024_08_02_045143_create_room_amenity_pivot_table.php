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
        Schema::create('room_amenity', function (Blueprint $table) {
            $table->foreignId('room_id')->index();
            $table->foreign('room_id')->on('rooms')->references('id')->cascadeOnDelete();
            $table->foreignId('amenity_id')->index();
            $table->foreign('amenity_id')->on('amenities')->references('id')->cascadeOnDelete();
            $table->primary(['room_id', 'amenity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_amenity');
    }
};
