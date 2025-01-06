<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSajInjuryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saj_injury_reports', function (Blueprint $table) {

            $table->bigIncrements('id');//タイムスタンプ
            $table->string('email', 256);//メールアドレス
            $table->string('score', 64)->nullable();//スコア
            $table->tinyInteger('reporter_type');//報告者種別
            $table->string('reporter_name', 256);//報告者名
            $table->tinyInteger('discipline');//〈競技種目〉
            $table->string('site', 256);//会場名
            $table->string('country', 256);//国名
            $table->tinyInteger('category');//カテゴリー
            $table->string('competition', 64)->nullable();//大会名
            $table->string('codex', 64)->nullable();//コーデックス
            $table->date('injured_date');//受傷年月日
            $table->string('name', 256);//選手名
            $table->tinyInteger('gender');//性別
            $table->date('birth_date');//生年月日
            $table->string('team', 256);//所属先
            $table->tinyInteger('body_part_injured');//傷害部位
            $table->tinyInteger('injury_type');//傷害のタイプ
            $table->string('injury_type_other', 256)->nullable();//その他
            $table->tinyInteger('side');//受傷側
            $table->tinyInteger('expected_absence');//トレーニング及び試合への不参加見込み期間
            $table->longText('multiple_injuries')->nullable();//複数の傷害（重篤順）
            $table->tinyInteger('consultation');//医師による診察の有無
            //$table->tinyInteger('body_part_injured_2');//傷害部位 2
            //$table->tinyInteger('injury_type_2');//傷害のタイプ 2
            //$table->string('injury_type_other_2', 256)->nullable();//その他 2
            //$table->tinyInteger('side_2');//受傷側 2
            $table->string('specific_diagnosis', 512)->nullable();//具体的な診断名
            $table->string('medical_certificate_path', 512)->nullable();//診断書の写しがある場合はアップロードしてください。
            $table->string('diagnosing_doctor', 512)->nullable();//診断医名
            $table->string('doctor_affiliation', 512)->nullable();//所属
            $table->string('doctor_email_of_telno', 256)->nullable();//電話orE-mail
            $table->longText('multiple_injuries_tmp')->nullable();//複数の傷害（重篤順）
            $table->tinyInteger('circumstances');//大会 or 練習
            $table->string('circumstance_other', 512)->nullable();//大会 or 練習その他
            $table->tinyInteger('binding_release');//受傷時ビンディング解放の有無
            $table->tinyInteger('type_of_snow');//雪質、地面
            $table->string('type_of_snow_other', 512)->nullable();//大会 or 練習その他
            $table->string('course_conditions', 512);//コースの状況
            $table->string('course_condition_other', 512)->nullable();//大会 or 練習その他
            $table->string('weather_conditions', 128);//気象状況
            $table->tinyInteger('wind_conditions');//風の状況
            $table->tinyInteger('video');//映像の有無
            $table->string('video_path', 512)->nullable();//映像をアップロードしてください。
            $table->longText('explain')->nullable();//Explain 上記に関する説明
            $table->longText('way_to_get_video')->nullable();//上記ビデオのコピー入手方法があれば記して下さい
            $table->longText('additional_information')->nullable();//気付いた等、補足情報があれば記入してください
            $table->string('reserve1', 256)->nullable();//その他
            $table->string('reserve2', 256)->nullable();//その他
            $table->string('reserve3', 256)->nullable();//その他
            $table->string('reserve4', 256)->nullable();//その他
            $table->string('reserve5', 256)->nullable();//その他
            $table->string('reserve6', 256)->nullable();//その他
            $table->string('reserve7', 256)->nullable();//その他
            $table->datetime('create_time');//作成日
            $table->datetime('update_time');//更新日
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
        Schema::dropIfExists('saj_injury_reports');
    }
}
