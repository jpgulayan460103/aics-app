<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAicsAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aics_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aics_assistance_id')->nullable();
            $table->date('requested_date')->nullable();
            $table->time('requested_time')->nullable();
            $table->date('served_date')->nullable();
            $table->time('served_time')->nullable();
            $table->string('status')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aics_appointments');
    }
}
