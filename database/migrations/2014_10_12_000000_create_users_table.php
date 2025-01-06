<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');//ID
            $table->string('name');//氏名
            $table->string('furigana')->nullable();//氏名（フリガナ）
            $table->string('gender');//性別
            $table->string('part');//役職
            $table->string('email', 191)->unique();//メールアドレス
            $table->timestamp('email_verified_at')->nullable();//メールアドレス検証用
            $table->string('password');//パスワード
            $table->string('jiss_share_id', 64);//ユーザーID
            $table->tinyInteger('role')->nullable();//権限
            $table->string('jiss_share_group');//JISS shareグループ
            $table->string('affiliation');//所属グループ
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
