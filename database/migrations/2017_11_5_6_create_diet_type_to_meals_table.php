<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDietTypeToMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //Ova tablica prikazuje pripadnost temeljnog jela s tipovima prehrane

    public function up()
    {
        Schema::create('diet_type_to_meals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meal_id')->unsigned(); //Connect diet type with parent_meals
            $table->integer('type_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diet_type_to_meals');
    }
}
