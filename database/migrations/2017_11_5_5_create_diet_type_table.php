<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDietTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Create diet type table
     * @return void
     */

    //Tablica za tipove prehrane (R,VG,V,GF)

    public function up()
    {
        Schema::create('diet_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diet_type');
    }
}
