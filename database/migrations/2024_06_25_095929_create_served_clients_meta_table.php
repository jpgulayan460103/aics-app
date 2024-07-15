<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServedClientsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('served_clients_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('served_client_id');
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            $table->foreign('served_client_id')->references('id')->on('served_clients')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('served_clients_meta');
    }
}
