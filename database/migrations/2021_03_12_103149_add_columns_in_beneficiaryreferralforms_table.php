<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInBeneficiaryreferralformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaryreferralforms', function (Blueprint $table) {
            $table->string('attachment')->nullable();
            $table->longText('map_lat')->nullable();
            $table->longText('map_long')->nullable();
            $table->longText('map_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficiaryreferralforms', function (Blueprint $table) {
            //
        });
    }
}
