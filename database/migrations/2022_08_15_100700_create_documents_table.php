<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aics_documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_directory')->nullable();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('aics_requrement_id')->nullable();
            $table->unsignedBigInteger('aics_assistance_id')->nullable();
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
        Schema::dropIfExists('aics_documents');
    }
}
