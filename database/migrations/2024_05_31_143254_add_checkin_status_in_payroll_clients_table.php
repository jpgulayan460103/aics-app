<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckinStatusInPayrollClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payroll_clients', function (Blueprint $table) {
            $table->string('checkin_status')->nullable();
            $table->date("date_checkin")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_clients', function (Blueprint $table) {
            $table->dropColumn('checkin_status');
            $table->dropColumn('date_checkin');
        });
    }
}
