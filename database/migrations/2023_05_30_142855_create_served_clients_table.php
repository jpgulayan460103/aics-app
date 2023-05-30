<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServedClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('served_clients', function (Blueprint $table) {
            $table->id();
            $table->dateTime('entered_datetime')->nullable();
            $table->string('entered_by')->nullable();
            $table->integer('client_number')->nullable();
            $table->dateTime('accomplished_datetime')->nullable();
            $table->integer("psgc")->unsigned()->nullable();
            $table->bigInteger("psgc_id")->unsigned()->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->string('meta_last_name')->nullable();
            $table->string('meta_first_name')->nullable();
            $table->string('meta_middle_name')->nullable();
            $table->string('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('age')->nullable();
            $table->string('mode_of_admission')->nullable();
            $table->string('type_of_assistance')->nullable();
            $table->string('amount')->nullable();
            $table->string('source_of_fund')->nullable();
            $table->string('client_category')->nullable();
            $table->string('charging')->nullable();
            $table->string('mode_of_assistance')->nullable();
            $table->date('date_claimed')->nullable();
            $table->string('uuid')->nullable();
            $table->timestamps();
            $table->index('uuid');
            $table->index('date_claimed');
            $table->index('meta_last_name');
            $table->index('meta_first_name');
            $table->index('meta_middle_name');
            $table->index('last_name');
            $table->index('first_name');
            $table->index('middle_name');
            $table->foreign('psgc_id')->references('id')->on('psgcs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('served_clients');
    }
}
