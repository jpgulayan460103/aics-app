<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAicsBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aics_beneficiaries', function (Blueprint $table) {
            $table->longText("assessment")->nullable();
            $table->string("interviewed_by");
            $table->string("subcategory_others")->nullable();
        });


        Schema::table('aics_beneficiaries', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->foreign('category_id')->references('id')->on('category_id')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aics_beneficiaries', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn('subcategory_others');
            $table->dropColumn('interviewed_by');
            $table->dropColumn('assessment');
            $table->dropColumn('subcategory_id');
            $table->dropColumn('category_id');
        });
    }
}
