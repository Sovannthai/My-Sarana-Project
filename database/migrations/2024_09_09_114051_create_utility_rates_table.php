<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityRatesTable extends Migration
{
    public function up()
    {
        Schema::create('utility_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Electricity', 'Water']);
            $table->decimal('rateperunit', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utility_rates');
    }
}
