<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     * Table for translated meals names.
     * @return void
     */

    public function up()
    {
        Schema::create('meals_translation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meal_id')->unsigned(); //reference to parent_meals table
            $table->string('name');  //translated
            $table->string('preparation'); //translated
            $table->string('description'); //translated
            $table->string('locale')->index();  // language identifier
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meals_translation');
    }
}
