<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAicsTypeIdInPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->bigInteger("aics_type_id")->unsigned()->nullable();
            $table->foreign('aics_type_id')->references('id')->on('aics_types');

            $table->bigInteger("aics_type_subcategory_id")->unsigned()->nullable();
            $table->foreign('aics_type_subcategory_id')->references('id')->on('aics_type_subcategories');
     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropForeign(['aics_type_id']);
            $table->dropColumn('aics_type_id');

            $table->dropForeign(['aics_type_subcategory_id']);
            $table->dropColumn('aics_type_subcategory_id');
        });

    }
}
