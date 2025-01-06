<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSajTypeOfSnowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saj_type_of_snows', function (Blueprint $table) {
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
        Schema::dropIfExists('saj_type_of_snows');
    }
}
