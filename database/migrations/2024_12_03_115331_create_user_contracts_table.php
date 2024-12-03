<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Links to the users table
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // Links to the rooms table
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('monthly_rent', 10, 2); // Stores rent as a numeric value
            $table->string('contract_pdf'); // Stores the path of the PDF file
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_contracts');
    }
}
