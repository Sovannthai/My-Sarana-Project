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
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('room_price',10,2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('total_discount',10,2)->default(0);
            $table->enum('discount_type',['amount','percentage'])->nullable();
            $table->decimal('total_amount_amenity',10,2)->default(0);
            $table->decimal('total_utility_amount',10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('room_price');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('total_discount');
            $table->dropColumn('discount_type');
            $table->dropColumn('total_amount_amenity');
            $table->dropColumn('total_utility_amount');
        });
    }
};
