<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsNutritionTable extends Migration
{
    /**
     * Run the migrations.
     * Connect meals table with nutritional value.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('meals_nutrition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meal_id')->unsigned();
            $table->float('fat_amount');
            $table->float('protein_amount');
            $table->float('sugar_amount');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meals_nutrition');
    }
}
