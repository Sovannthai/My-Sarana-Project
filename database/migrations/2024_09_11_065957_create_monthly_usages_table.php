<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('monthly_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('waterusage', 10, 2)->default(0);
            $table->decimal('electricityusage', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('monthly_usage');
    }
};
