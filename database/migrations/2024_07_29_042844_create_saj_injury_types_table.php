<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSajInjuryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saj_injury_types', function (Blueprint $table) {
            $table->tinyInteger('id');
            $table->string('name_en');
            $table->string('name');
            $table->tinyInteger('delete_flag')->default(0);//削除フラグ
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saj_injury_types');
    }
}
