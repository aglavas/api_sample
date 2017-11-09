<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateIndexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Adding foreign keys and other constrains. This migration is intended to run last.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meals_nutrition', function (Blueprint $table) {
            $table->index('meal_id');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });

        Schema::table('meals_translation', function (Blueprint $table) {
            $table->index('meal_id');
            $table->unique(['meal_id', 'locale']); //combination of these two keys must be unique
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade'); ///foregin key for parent_meals
        });

        Schema::table('diet_type_to_meals', function (Blueprint $table) {
            $table->index('meal_id');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('diet_type')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meals_nutrition', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropIndex(['meal_id']);
        });

        Schema::table('meals_translation', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropIndex(['meal_id']);
            $table->dropUnique(['meal_id', 'locale']);
        });

        Schema::table('diet_type_to_meals', function (Blueprint $table) {
            $table->dropForeign(['meal_id']);
            $table->dropForeign(['type_id']);
            $table->dropIndex(['meal_id']);
            $table->dropIndex(['type_id']);
        });
    }
}
