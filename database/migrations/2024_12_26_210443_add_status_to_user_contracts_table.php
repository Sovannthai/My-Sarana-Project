<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUserContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_contracts', function (Blueprint $table) {
            $table->string('status')->default('active')->after('contract_pdf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_contracts', function (Blueprint $table) {
            $table->dropColumn('status'); // Drops the 'status' column if rolled back
        });
    }
}
