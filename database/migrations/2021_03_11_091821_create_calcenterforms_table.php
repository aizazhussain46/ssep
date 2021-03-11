<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalcenterformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calcenterforms', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->longText('form_no')->nullable();
            $table->string('date')->nullable();
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('district')->nullable();
            $table->string('uc')->nullable();
            $table->string('taluka')->nullable();
            $table->string('village')->nullable();
            $table->longText('n_landmark')->nullable();
            $table->longText('address')->nullable();
            $table->integer('male_count')->default(0)->nullable();
            $table->integer('female_count')->default(0)->nullable();
            $table->integer('children_count')->default(0)->nullable();
            $table->longText('source_of_info')->nullable();
            $table->string('electricity')->nullable();
            $table->longText('loadshedding_hours')->nullable();
            $table->string('mocrofinanceload')->nullable();
            $table->longText('mfi')->nullable();
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
        Schema::dropIfExists('calcenterforms');
    }
}
