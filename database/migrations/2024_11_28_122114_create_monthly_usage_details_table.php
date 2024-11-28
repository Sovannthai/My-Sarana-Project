<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_usage_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_usage_id')->constrained('monthly_usages')->cascadeOnDelete();
            $table->foreignId('utility_type_id')->constrained('utility_types')->cascadeOnDelete();
            $table->decimal('usage', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_usage_details');
    }
};
