<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldactivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fieldactivities', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('date')->nullable();
            $table->string('activity_name')->nullable();
            $table->string('district')->nullable();
            $table->string('uc')->nullable();
            $table->string('taluka')->nullable();
            $table->string('village')->nullable();
            $table->string('DO_name')->nullable();
            $table->integer('count_participants')->default(0)->nullable();
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->longText('details')->nullable();
            $table->longText('images')->nullable();
            $table->longText('attendance_sheet')->nullable();
            $table->longText('map_lat')->nullable();
            $table->longText('map_long')->nullable();
            $table->longText('map_location')->nullable(); 
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
        Schema::dropIfExists('fieldactivities');
    }
}
