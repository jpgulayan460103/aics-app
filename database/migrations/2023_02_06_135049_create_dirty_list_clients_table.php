<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirtyListClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dirty_list_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dirty_list_id')->nullable();
            $table->foreign('dirty_list_id')->references('id')->on('dirty_lists')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city_muni')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('fund_source')->nullable();
            $table->string("file_name")->nullable();
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
        Schema::table('dirty_list_clients', function (Blueprint $table) {
            $table->dropForeign(['dirty_list_id']);
        });

        Schema::dropIfExists('dirty_list_clients');
    }
}
