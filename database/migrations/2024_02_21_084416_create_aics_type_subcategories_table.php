<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAicsTypeSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aics_type_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger('aics_type_id')->nullable();
            $table->foreign('aics_type_id')->references('id')->on('aics_types')->onDelete('cascade');
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
        Schema::table('aics_type_subcategories', function (Blueprint $table) {
            $table->dropForeign(['aics_type_id']);
            $table->dropColumn('aics_type_id');
        });

        Schema::dropIfExists('aics_type_subcategories');
    }
}
