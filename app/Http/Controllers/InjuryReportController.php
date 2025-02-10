<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SajInjuryReport;
use Auth;
use Carbon\Carbon;
use App\Models\SajReporterType;
use App\Models\SajDiscipline;
use App\Models\SajCategory;
use App\Models\SajGender;
use App\Models\SajCircumstance;
use App\Models\SajInjuredBodyPart;
use App\Models\SajSide;
use App\Models\SajInjuryType;
use App\Models\SajExpectedAbsence;
use App\Models\SajWithOrWithout;

use App\Models\SajCourseCondition;
use App\Models\SajTypeOfSnow;
use App\Models\SajWeatherCondition;
use App\Models\SajWindCondition;
use App\Models\SajVideo;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;//重要

class InjuryReportController extends Controller
{
    //
    var $medical_certificate_file;
    var $video_file;


    /**
     */
    public function index()
    {
        $user = Auth::user();
        $id = Auth::id();
        $genders = SajGender::get();
        $disciplines = SajDiscipline::get();
        $body_part_injureds = SajInjuredBodyPart::get();
        $injury_types = SajInjuryType::get();
        $videos = SajVideo::get();

        if($user==null){
            return redirect('/');
        }
        //全部取得
        //if($user->role==0){
        //    $injuryreports = SajInjuryReport::where('email', $user->email)->orderBy('injured_date', 'desc')->paginate(10);
        //}else{
            $injuryreports = SajInjuryReport::orderBy('injured_date', 'desc')->paginate(10);
        //}
        // 全件数を取得
        $totalReports = $injuryreports->total();

        // 各レコードのupdate_timeをフォーマット
        foreach ($injuryreports as $report) {
            $report->formatted_injured_date = Carbon::parse($report->injured_date)->format('Y-m-d');
        }

        //選択状態
        $gender_no = 0;
        $discipline_no = 0;
        $body_part_injured_no = 0;

        //ddd($injuryreports);
        return view('injury',compact(
            'user',
            'genders',
            'injuryreports',
            'totalReports',
            'disciplines',
            'body_part_injureds',
            'injury_types',
            'videos',
            'gender_no',
            'discipline_no',
            'body_part_injured_no',
        ));
    }

    /**
     */
    public function search(Request $request)
    {
        $user = Auth::user();
        $id = Auth::id();
        $genders = SajGender::get();
        $disciplines = SajDiscipline::get();
        $body_part_injureds = SajInjuredBodyPart::get();
        $injury_types = SajInjuryType::get();
        $videos = SajVideo::get();

        if($user==null){
            return redirect('/');
        }
        //全部取得
        //$injuryreports = SajInjuryReport::all();
        $injuryreports = SajInjuryReport::orderBy('injured_date', 'desc');

        //選択状態
        $gender_no = $request->input('gender');
        $discipline_no = $request->input('discipline');
        $body_part_injured_no = $request->input('body_part_injured');

        //ddd($request->input('has_medical_certificate'),$request->input('has_video'));

        // 診断書有無絞り込み
        if (!empty($request->input('has_medical_certificate'))){
            $injuryreports= $injuryreports->whereNotNull('medical_certificate_path')->where(DB::raw('LENGTH(medical_certificate_path)'), '>', 0);
        }
        // 動画有無絞り込み
        if (!empty($request->input('has_video'))){
            $injuryreports= $injuryreports->whereNotNull('video_path')->where(DB::raw('LENGTH(video_path)'), '>', 0);
        }

        // 性別絞り込み
        if (!empty($gender_no)){
            $injuryreports= $injuryreports->where('gender', $gender_no);
        }

        // 性別絞り込み
        if (!empty($gender_no)){
            $injuryreports= $injuryreports->where('gender', $gender_no);
        }
        // 種目絞り込み
        if (!empty($discipline_no)){
            $injuryreports= $injuryreports->where('discipline', $discipline_no);
        }
        // 傷害部位絞り込み
        if (!empty($body_part_injured_no)){
            $injuryreports= $injuryreports->where('body_part_injured', $body_part_injured_no);
        }
        //ddd($injuryreports);

        //ページネーション
        $injuryreports = $injuryreports->paginate(10);
        // 全件数を取得
        $totalReports = $injuryreports->total();

        // 各レコードのupdate_timeをフォーマット
        foreach ($injuryreports as $report) {
            $report->formatted_injured_date = Carbon::parse($report->injured_date)->format('Y-m-d');
        }

        //ddd($injuryreports);
        return view('injury',compact(
            'user',
            'injuryreports',
            'totalReports',
            'genders',
            'disciplines',
            'body_part_injureds',
            'injury_types',
            'videos',
            'gender_no',
            'discipline_no',
            'body_part_injured_no',
        ));
    }

    /**
     */
    public function register(Request $request)
    {
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        //バリデーション
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:256',
            'reporter_type' => 'required',
            'reporter_name' => 'required|max:256',
            'discipline' => 'required',
            'site' => 'required|max:256',
            'country' => 'required|max:256',
            'injured_date' => 'required',
            'name' => 'required|max:256',
            'gender' => 'required',
            'birth_date' => 'required',
            'team' => 'required|max:256',
            'body_part_injured' => 'required',
            'injury_type' => 'required',
            'side' => 'required',
            'expected_absence' => 'required',
            'consultation' => 'required',
            'type_of_snow' => 'required',
            'course_conditions' => 'required|max:512',
            'weather_conditions' => 'required|max:128',
            'video' => 'required',
        ]);

        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/report/create')
                ->withInput()
                ->withErrors($validator);
        }

        $medical_certificate_file = $request->file('medical_certificate_path'); //file取得
        $video_file = $request->file('video_path'); //file取得


        // 一時的にストレージに保存
        if ($medical_certificate_file) {
            $path = $medical_certificate_file->store('temp');
            // 保存パスをセッションに保持するか、確認画面に渡す
            session(['medical_certificate_file' => $path]);
        }
        if ($video_file) {
            $path = $video_file->store('temp');
            // 保存パスをセッションに保持するか、確認画面に渡す
            session(['video_file' => $path]);
        }

        //if( !empty($medical_certificate_file) ){                //fileが空かチェック
        //    $filename = $medical_certificate_file->getClientOriginalName();   //ファイル名を取得
        //    $move = $medical_certificate_file->move('./upload/medical_certificate/',$filename);  //ファイルを移動：パスが“./upload/”の場合もあるCloud9
        //}else{
        //    $filename = "";
        //}
      //
        //if( !empty($video_file) ){                //fileが空かチェック
        //    $filename = $video_file->getClientOriginalName();   //ファイル名を取得
        //    $move = $video_file->move('./upload/video',$filename);  //ファイルを移動：パスが“./upload/”の場合もあるCloud9
        //}else{
        //    $filename = "";
        //}


        //ddd($request);
        $injuryreport=new SajInjuryReport;
        //すべての項目を挙げる
        //$injuryreport->id = $request->input('id');
        $injuryreport->email = $request->input('email');
        $injuryreport->score = $request->input('score');
        $injuryreport->reporter_type = $request->input('reporter_type');
        $injuryreport->reporter_name = $request->input('reporter_name');
        $injuryreport->discipline = $request->input('discipline');
        $injuryreport->site = $request->input('site');
        $injuryreport->country = $request->input('country');
        $injuryreport->category = $request->input('category');
        $injuryreport->competition = $request->input('competition');
        $injuryreport->codex = $request->input('codex');
        $injuryreport->injured_date = $request->input('injured_date');
        $injuryreport->name = $request->input('name');
        $injuryreport->gender = $request->input('gender');
        $injuryreport->birth_date = $request->input('birth_date');
        $injuryreport->team = $request->input('team');
        $injuryreport->body_part_injured = $request->input('body_part_injured');
        $injuryreport->injury_type = $request->input('injury_type');
        $injuryreport->injury_type_other = $request->input('injury_type_other');
        $injuryreport->side = $request->input('side');
        $injuryreport->expected_absence = $request->input('expected_absence');
        $injuryreport->multiple_injuries = $request->input('multiple_injuries');
        $injuryreport->consultation = $request->input('consultation');
        //$injuryreport->body_part_injured_2 = $request->input('body_part_injured_2');
        //$injuryreport->injury_type_2 = $request->input('injury_type_2');
        //$injuryreport->injury_type_other_2 = $request->input('injury_type_other_2');
        //$injuryreport->side_2 = $request->input('side_2');
        $injuryreport->specific_diagnosis = $request->input('specific_diagnosis');
        $injuryreport->medical_certificate_path = $medical_certificate_file?$medical_certificate_file->getClientOriginalName();   //ファイル名を取得
        $injuryreport->diagnosing_doctor = $request->input('diagnosing_doctor');
        $injuryreport->doctor_affiliation = $request->input('doctor_affiliation');
        $injuryreport->doctor_email_of_telno = $request->input('doctor_email_of_telno');
        $injuryreport->multiple_injuries_tmp = $request->input('multiple_injuries_tmp');
        $injuryreport->circumstances = $request->input('circumstances');
        $injuryreport->circumstance_other = $request->input('circumstance_other');
        $injuryreport->binding_release = $request->input('binding_release');
        $injuryreport->type_of_snow = $request->input('type_of_snow');
        $injuryreport->type_of_snow_other = $request->input('type_of_snow_other');
        //複数
        // 'course_conditions'は配列として送信されるので、implodeを使ってカンマ区切りの文字列に変換
        $injuryreport->course_conditions = implode(',', $request->input('course_conditions'));
        $injuryreport->course_condition_other = $request->input('course_condition_other');
        //複数
        // 'weather_conditions'は配列として送信されるので、implodeを使ってカンマ区切りの文字列に変換
        $injuryreport->weather_conditions = implode(',', $request->input('weather_conditions'));
        $injuryreport->wind_conditions = $request->input('wind_conditions');
        $injuryreport->video = $request->input('video');
        $injuryreport->video_path = $video_file?$video_file->getClientOriginalName():"";   //ファイル名を取得
        $injuryreport->explain = $request->input('explain');
        $injuryreport->way_to_get_video = $request->input('way_to_get_video');
        $injuryreport->additional_information = $request->input('additional_information');
        //$injuryreport->reserve1 = $request->input('reserve1');
        //$injuryreport->reserve2 = $request->input('reserve2');
        //$injuryreport->reserve3 = $request->input('reserve3');
        //$injuryreport->reserve4 = $request->input('reserve4');
        //$injuryreport->reserve5 = $request->input('reserve5');
        //$injuryreport->reserve6 = $request->input('reserve6');
        //$injuryreport->reserve7 = $request->input('reserve7');
        $injuryreport->create_time = now();
        $injuryreport->update_time = now();
        $injuryreport->delete_flag = 0;

        // セッションにデータを保存
        session([
            //'id' => $injuryreport->id,
            'email' => $injuryreport->email,
            'score' => $injuryreport->score,
            'reporter_type' => $injuryreport->reporter_type,
            'reporter_name' => $injuryreport->reporter_name,
            'discipline' => $injuryreport->discipline,
            'site' => $injuryreport->site,
            'country' => $injuryreport->country,
            'category' => $injuryreport->category,
            'competition' => $injuryreport->competition,
            'codex' => $injuryreport->codex,
            'injured_date' => $injuryreport->injured_date,
            'name' => $injuryreport->name,
            'gender' => $injuryreport->gender,
            'birth_date' => $injuryreport->birth_date,
            'team' => $injuryreport->team,
            'body_part_injured' => $injuryreport->body_part_injured,
            'injury_type' => $injuryreport->injury_type,
            'injury_type_other' => $injuryreport->injury_type_other,
            'side' => $injuryreport->side,
            'expected_absence' => $injuryreport->expected_absence,
            'multiple_injuries' => $injuryreport->multiple_injuries,
            'consultation' => $injuryreport->consultation,
            //'body_part_injured_2' => $injuryreport->body_part_injured_2,
            //'injury_type_2' => $injuryreport->injury_type_2,
            //'injury_type_other_2' => $injuryreport->injury_type_other_2,
            //'side_2' => $injuryreport->side_2,
            'specific_diagnosis' => $injuryreport->specific_diagnosis,
            'medical_certificate_path' => $injuryreport->medical_certificate_path,
            'diagnosing_doctor' => $injuryreport->diagnosing_doctor,
            'doctor_affiliation' => $injuryreport->doctor_affiliation,
            'doctor_email_of_telno' => $injuryreport->doctor_email_of_telno,
            'multiple_injuries_tmp' => $injuryreport->multiple_injuries_tmp,
            'circumstances' => $injuryreport->circumstances,
            'circumstance_other' => $injuryreport->circumstance_other,
            'binding_release' => $injuryreport->binding_release,
            'type_of_snow' => $injuryreport->type_of_snow,
            'type_of_snow_other' => $injuryreport->type_of_snow_other,
            'course_conditions' => $injuryreport->course_conditions,
            'course_condition_other' => $injuryreport->course_condition_other,
            'weather_conditions' => $injuryreport->weather_conditions,
            'wind_conditions' => $injuryreport->wind_conditions,
            'video' => $injuryreport->video,
            'video_path' => $injuryreport->video_path,
            'explain' => $injuryreport->explain,
            'way_to_get_video' => $injuryreport->way_to_get_video,
            'additional_information' => $injuryreport->additional_information,
            //'reserve1' => $injuryreport->reserve1,
            //'reserve2' => $injuryreport->reserve2,
            //'reserve3' => $injuryreport->reserve3,
            //'reserve4' => $injuryreport->reserve4,
            //'reserve5' => $injuryreport->reserve5,
            //'reserve6' => $injuryreport->reserve6,
            //'reserve7' => $injuryreport->reserve7,
            'create_time' => $injuryreport->create_time,
            'update_time' => $injuryreport->update_time,
            'delete_flag' => $injuryreport->delete_flag,
        ]);

        //ddd($this);

        //一覧表示画面にリダイレクト
        //return redirect('confirm');
        return view('confirm',
        [
            'user' => $user,
            'injuryreport' => $injuryreport
        ]);

    }

    function save(){
        // セッションからデータを取得
        //$data = session();//->only(['name', 'email']);
        $injuryreport=new SajInjuryReport;
        //すべての項目を挙げる
        //$injuryreport->id = session('id');
        $injuryreport->email = session('email');
        $injuryreport->score = session('score');
        $injuryreport->reporter_type = session('reporter_type');
        $injuryreport->reporter_name = session('reporter_name');
        $injuryreport->discipline = session('discipline');
        $injuryreport->site = session('site');
        $injuryreport->country = session('country');
        $injuryreport->category = session('category');
        $injuryreport->competition = session('competition');
        $injuryreport->codex = session('codex');
        $injuryreport->injured_date = session('injured_date');
        $injuryreport->name = session('name');
        $injuryreport->gender = session('gender');
        $injuryreport->birth_date = session('birth_date');
        $injuryreport->team = session('team');
        $injuryreport->body_part_injured = session('body_part_injured');
        $injuryreport->injury_type = session('injury_type');
        $injuryreport->injury_type_other = session('injury_type_other');
        $injuryreport->side = session('side');
        $injuryreport->expected_absence = session('expected_absence');
        $injuryreport->multiple_injuries = session('multiple_injuries');
        $injuryreport->consultation = session('consultation');
        //$injuryreport->body_part_injured_2 = session('body_part_injured_2');
        //$injuryreport->injury_type_2 = session('injury_type_2');
        //$injuryreport->injury_type_other_2 = session('injury_type_other_2');
        //$injuryreport->side_2 = session('side_2');
        $injuryreport->specific_diagnosis = session('specific_diagnosis');
        $injuryreport->medical_certificate_path = session('medical_certificate_path');
        $injuryreport->diagnosing_doctor = session('diagnosing_doctor');
        $injuryreport->doctor_affiliation = session('doctor_affiliation');
        $injuryreport->doctor_email_of_telno = session('doctor_email_of_telno');
        $injuryreport->multiple_injuries_tmp = session('multiple_injuries_tmp');
        $injuryreport->circumstances = session('circumstances');
        $injuryreport->circumstance_other = session('circumstance_other');
        $injuryreport->binding_release = session('binding_release');
        $injuryreport->type_of_snow = session('type_of_snow');
        $injuryreport->type_of_snow_other = session('type_of_snow_other');
        $injuryreport->course_conditions = session('course_conditions');
        $injuryreport->course_condition_other = session('course_condition_other');
        $injuryreport->weather_conditions = session('weather_conditions');
        $injuryreport->wind_conditions = session('wind_conditions');
        $injuryreport->video = session('video');
        $injuryreport->video_path = session('video_path');
        $injuryreport->explain = session('explain');
        $injuryreport->way_to_get_video = session('way_to_get_video');
        $injuryreport->additional_information = session('additional_information');
        //$injuryreport->reserve1 = session('reserve1');
        //$injuryreport->reserve2 = session('reserve2');
        //$injuryreport->reserve3 = session('reserve3');
        //$injuryreport->reserve4 = session('reserve4');
        //$injuryreport->reserve5 = session('reserve5');
        //$injuryreport->reserve6 = session('reserve6');
        //$injuryreport->reserve7 = session('reserve7');
        $injuryreport->create_time = session('create_time');
        $injuryreport->update_time = session('update_time');
        $injuryreport->delete_flag = session('delete_flag');

        //ddd($injuryreport);

        // セッションからストレージのファイルパスを取得
        $medical_certificate_path = session('medical_certificate_file');
        $video_file_path = session('video_file');
        //ddd([$video_file_path, $medical_certificate_path]);

        if ($medical_certificate_path) {
            // ファイルを移動
            $filename = basename($medical_certificate_path);
            //ddd([$filename, $medical_certificate_path,$injuryreport->medical_certificate_path]);
            Storage::move($medical_certificate_path, 'public/upload/medical_certificate/' . $injuryreport->medical_certificate_path);
            //ddd([$filename, $medical_certificate_path,$injuryreport->medical_certificate_path]);
            // セッションからファイルパスを削除
            session()->forget('medical_certificate_path');
        } else {
            $filename = "";
        }

        if ($video_file_path) {
            // ファイルを移動
            $filename = basename($video_file_path);
            Storage::move($video_file_path, 'public/upload/video/' . $injuryreport->video_path);

            // セッションからファイルパスを削除
            session()->forget('video_file');
        } else {
            $filename = "";
        }

        //ddd($injuryreport);
        // データベースに保存する処理
        $injuryreport->save();

        // セッションデータをクリア
        //session()->forget(['name', 'email']);

        return redirect('/home');//->route('form')->with('success', '登録が完了しました！');
    }


    public function report($mode='create'){
        $user = Auth::user();
        $id = Auth::id();

        if($user==null){
            return redirect('/');
        }
        $reporter_types = SajReporterType::get();
        $disciplines = SajDiscipline::get();
        $categorys = SajCategory::get();
        $genders = SajGender::get();
        $circumstances = SajCircumstance::get();
        $body_part_injureds = SajInjuredBodyPart::get();
        $sides = SajSide::get();
        $injury_types = SajInjuryType::get();
        $expected_absences = SajExpectedAbsence::get();
        $consultations = SajWithOrWithout::get();

        $binding_releases = SajWithOrWithout::get();
        $weather_conditions = SajWeatherCondition::get();
        $type_of_snows = SajTypeOfSnow::get();
        $course_conditions = SajCourseCondition::get();
        $wind_conditions = SajWindCondition::get();
        $videos = SajVideo::get();

        if ($mode === 'create') {
            // 新規登録処理
            $mode = "create";
        } elseif ($mode === 'edit') {
            // 更新処理
            $mode = "edit";
        } else {
            // 無効なモードの場合の処理
            $mode = "show";
        }

        //ddd($reporter_type);
        //ddd($user->email);
        return view('report',compact(
            'mode',
            'user',
            'reporter_types',
            'disciplines',
            'categorys',
            'genders',
            'circumstances',
            'body_part_injureds',
            'sides',
            'injury_types',
            'expected_absences',
            'consultations',
            'binding_releases',
            'weather_conditions',
            'type_of_snows',
            'course_conditions',
            'wind_conditions',
            'videos'
        ));
    }

    private function common_detail($id, $mode){
        $user = Auth::user();
        //ddd($id, $mode);
        $injuryreport = SajInjuryReport::where('id', $id)->get()[0];

        $reporter_types = SajReporterType::get();
        $disciplines = SajDiscipline::get();
        $categorys = SajCategory::get();
        $genders = SajGender::get();
        $circumstances = SajCircumstance::get();
        $body_part_injureds = SajInjuredBodyPart::get();
        $sides = SajSide::get();
        $injury_types = SajInjuryType::get();
        $expected_absences = SajExpectedAbsence::get();
        $consultations = SajWithOrWithout::get();

        $binding_releases = SajWithOrWithout::get();
        $weather_conditions = SajWeatherCondition::get();
        $type_of_snows = SajTypeOfSnow::get();
        $course_conditions = SajCourseCondition::get();
        $wind_conditions = SajWindCondition::get();
        $videos = SajVideo::get();

        $medicalcertificatelink = "";

        $medicalcertificatepath = $injuryreport->medical_certificate_path;
        $videoPath = $injuryreport->video_path;

        if (strpos($medicalcertificatepath, 'drive.google.com') !== false) {
            // drive.google.comが含まれている場合の処理
            $medicalcertificatelink = '<div><a href="'.$medicalcertificatepath.'" target="_blank" class="btn btn-primary">診断書</a></div>';
        }else{
            if(strlen($medicalcertificatepath)>0){
                if (strpos($medicalcertificatepath, '.pdf') !== false) {
                    // PDFファイルの場合
                    $medicalcertificatelink = '<a href="/storage/upload/medical_certificate/'.$medicalcertificatepath.'" target="_blank">
                                                    <img src="/images/pdf-thumbnail.png" alt="PDF Thumbnail" id="thumbnail">
                                               </a>';
                } elseif (
                    strpos($medicalcertificatepath, '.png') !== false ||
                    strpos($medicalcertificatepath, '.PNG') !== false ||
                    strpos($medicalcertificatepath, '.jpg') !== false ||
                    strpos($medicalcertificatepath, '.JPG') !== false ||
                    strpos($medicalcertificatepath, '.jpeg') !== false) {

                    // 含まれていない場合の処理
                    $medicalcertificatelink = '<img src="/storage/upload/medical_certificate/'.$medicalcertificatepath.'" alt="Google Drive Image" id="thumbnail" class="small-image">';
                    $medicalcertificatelink .= '<img src="/storage/upload/medical_certificate/'.$medicalcertificatepath.'" alt="Google Drive Image" id="largeImage" class="img-fluid">';
                }
            }
        }

        $embedCode='';
        if (strpos($videoPath, 'drive.google.com') !== false) {
            // drive.google.comが含まれている場合の処理
            $embedCode='';
            //複数登録？
            if(strpos($videoPath, ',') !== false){
                $videoPaths = explode(',', $videoPath);
                foreach($videoPaths as $video_path){
                    $embedCode .= '<div class="mb-2"><a href="'.$video_path.'" target="_blank" class="btn btn-primary">動画を再生</a></div>';
                }
            }else{
            //$embedCode = '<iframe src="'.$videoPath.'" width="640" height="480" allow="autoplay"></iframe>';
            $embedCode = '<div><a href="'.$videoPath.'" target="_blank" class="btn btn-primary">動画を再生</a></div>';
            }
        //}elseif (strpos($videoPath, '.mp4') !== false) {
        } else {
            if(strlen($videoPath)>0){
                // 含まれていない場合の処理
                $embedCode = '<video width="90%" controls>
                            <source src="/storage/upload/video/'.$videoPath.'" type="video/mp4">
                            お使いのブラウザは動画タグに対応していません。
                          </video>';
            }else{
                $embedCode = "";
            }
        }

        //ddd($mode, $injuryreport);
        //ddd($medicalcertificatelink);
        return compact(
            'injuryreport',
            'user',
            'reporter_types',
            'disciplines',
            'categorys',
            'genders',
            'circumstances',
            'body_part_injureds',
            'sides',
            'injury_types',
            'expected_absences',
            'consultations',
            'binding_releases',
            'weather_conditions',
            'type_of_snows',
            'course_conditions',
            'wind_conditions',
            'videos',
            'medicalcertificatelink',
            'embedCode',
            'mode'
        );
    }

    /**
     */
    public function detail($id)
    {
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        $mode = 'view'; // 初期モードを設定
        $compact_value = $this->common_detail($id, $mode);
        //ddd($mode);
        return view('detail', $compact_value);
    }

    public function toggleMode(Request $request, $id)
    {
        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }
        $mode = $request->input('mode') === 'view' ? 'edit' : 'view';
        $compact_value = $this->common_detail($id, $mode);
        //ddd($mode);
        return view('detail', $compact_value);
    }

    /**
     */
    public function edit(Request $request, $id){
//        //バリデーション
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|max:256',
//            'reporter_type' => 'required',
//            'reporter_name' => 'required|max:256',
//            'discipline' => 'required',
//            'site' => 'required|max:256',
//            'country' => 'required|max:256',
//            'injured_date' => 'required',
//            'name' => 'required|max:256',
//            'gender' => 'required',
//            'birth_date' => 'required',
//            'team' => 'required|max:256',
//            'body_part_injured' => 'required',
//            'injury_type' => 'required',
//            'side' => 'required',
//            'expected_absence' => 'required',
//            'consultation' => 'required',
//            'type_of_snow' => 'required',
//            'course_conditions' => 'required|max:512',
//            'weather_conditions' => 'required|max:128',
//            'video' => 'required',
//        ]);
//
//        //バリデーション:エラー
//        if ($validator->fails()) {
//            return redirect('/report/create')
//                ->withInput()
//                ->withErrors($validator);
//        }

        $user = Auth::user();

        if($user==null){
            return redirect('/');
        }

        $medical_certificate_file = $request->file('medical_certificate_path'); //file取得
        $video_file = $request->file('video_path'); //file取得

        // 一時的にストレージに保存
        if ($medical_certificate_file) {
            $path = $medical_certificate_file->store('temp');
            // 保存パスをセッションに保持するか、確認画面に渡す
            session(['medical_certificate_file' => $path]);
        }
        if ($video_file) {
            $path = $video_file->store('temp');
            // 保存パスをセッションに保持するか、確認画面に渡す
            session(['video_file' => $path]);
        }

        //ddd($request);
        $cid = intval($id);
        $injuryreport = SajInjuryReport::where('id', $cid)->get()[0];

        //ddd($id, $cid, $medical_certificate_file, $video_file, $request->input('email'), $request->input('id'), $injuryreport);

        //すべての項目を挙げる
        //$injuryreport->id = $request->input('id');
        $injuryreport->email = $request->input('email');
        $injuryreport->score = $request->input('score');
        $injuryreport->reporter_type = $request->input('reporter_type');
        $injuryreport->reporter_name = $request->input('reporter_name');
        $injuryreport->discipline = $request->input('discipline');
        $injuryreport->site = $request->input('site');
        $injuryreport->country = $request->input('country');
        $injuryreport->category = $request->input('category');
        $injuryreport->competition = $request->input('competition');
        $injuryreport->codex = $request->input('codex');
        $injuryreport->injured_date = $request->input('injured_date');
        $injuryreport->name = $request->input('name');
        $injuryreport->gender = $request->input('gender');
        $injuryreport->birth_date = $request->input('birth_date');
        $injuryreport->team = $request->input('team');
        $injuryreport->body_part_injured = $request->input('body_part_injured');
        $injuryreport->injury_type = $request->input('injury_type');
        $injuryreport->injury_type_other = $request->input('injury_type_other');
        $injuryreport->side = $request->input('side');
        $injuryreport->expected_absence = $request->input('expected_absence');
        $injuryreport->multiple_injuries = $request->input('multiple_injuries');
        $injuryreport->consultation = $request->input('consultation');
        //$injuryreport->body_part_injured_2 = $request->input('body_part_injured_2');
        //$injuryreport->injury_type_2 = $request->input('injury_type_2');
        //$injuryreport->injury_type_other_2 = $request->input('injury_type_other_2');
        //$injuryreport->side_2 = $request->input('side_2');
        $injuryreport->specific_diagnosis = $request->input('specific_diagnosis');
        if($medical_certificate_file!=null){
            $injuryreport->medical_certificate_path = $medical_certificate_file->getClientOriginalName();   //ファイル名を取得
        }
        $injuryreport->diagnosing_doctor = $request->input('diagnosing_doctor');
        $injuryreport->doctor_affiliation = $request->input('doctor_affiliation');
        $injuryreport->doctor_email_of_telno = $request->input('doctor_email_of_telno');
        $injuryreport->multiple_injuries_tmp = $request->input('multiple_injuries_tmp');
        $injuryreport->circumstances = $request->input('circumstances');
        $injuryreport->circumstance_other = $request->input('circumstance_other');
        $injuryreport->binding_release = $request->input('binding_release');
        $injuryreport->type_of_snow = $request->input('type_of_snow');
        $injuryreport->type_of_snow_other = $request->input('type_of_snow_other');
        //複数
        // 'course_conditions'は配列として送信されるので、implodeを使ってカンマ区切りの文字列に変換
        $injuryreport->course_conditions = implode(',', $request->input('course_conditions'));
        $injuryreport->course_condition_other = $request->input('course_condition_other');
        //複数
        // 'weather_conditions'は配列として送信されるので、implodeを使ってカンマ区切りの文字列に変換
        $injuryreport->weather_conditions = implode(',', $request->input('weather_conditions'));
        $injuryreport->wind_conditions = $request->input('wind_conditions');
        $injuryreport->video = $request->input('video');
        if($video_file!=null){
            $injuryreport->video_path = $video_file->getClientOriginalName();   //ファイル名を取得
        }
        $injuryreport->explain = $request->input('explain');
        $injuryreport->way_to_get_video = $request->input('way_to_get_video');
        $injuryreport->additional_information = $request->input('additional_information');
        //$injuryreport->reserve1 = $request->input('reserve1');
        //$injuryreport->reserve2 = $request->input('reserve2');
        //$injuryreport->reserve3 = $request->input('reserve3');
        //$injuryreport->reserve4 = $request->input('reserve4');
        //$injuryreport->reserve5 = $request->input('reserve5');
        //$injuryreport->reserve6 = $request->input('reserve6');
        //$injuryreport->reserve7 = $request->input('reserve7');
        $injuryreport->create_time = now();
        $injuryreport->update_time = now();
        $injuryreport->delete_flag = 0;

        // セッションにデータを保存
        //session([
        //    //'id' => $injuryreport->id,
        //    'email' => $injuryreport->email,
        //    'score' => $injuryreport->score,
        //    'reporter_type' => $injuryreport->reporter_type,
        //    'reporter_name' => $injuryreport->reporter_name,
        //    'discipline' => $injuryreport->discipline,
        //    'site' => $injuryreport->site,
        //    'country' => $injuryreport->country,
        //    'category' => $injuryreport->category,
        //    'competition' => $injuryreport->competition,
        //    'codex' => $injuryreport->codex,
        //    'injured_date' => $injuryreport->injured_date,
        //    'name' => $injuryreport->name,
        //    'gender' => $injuryreport->gender,
        //    'birth_date' => $injuryreport->birth_date,
        //    'team' => $injuryreport->team,
        //    'body_part_injured' => $injuryreport->body_part_injured,
        //    'injury_type' => $injuryreport->injury_type,
        //    'injury_type_other' => $injuryreport->injury_type_other,
        //    'side' => $injuryreport->side,
        //    'expected_absence' => $injuryreport->expected_absence,
        //    'multiple_injuries' => $injuryreport->multiple_injuries,
        //    'consultation' => $injuryreport->consultation,
        //    //'body_part_injured_2' => $injuryreport->body_part_injured_2,
        //    //'injury_type_2' => $injuryreport->injury_type_2,
        //    //'injury_type_other_2' => $injuryreport->injury_type_other_2,
        //    //'side_2' => $injuryreport->side_2,
        //    'specific_diagnosis' => $injuryreport->specific_diagnosis,
        //    'medical_certificate_path' => $injuryreport->medical_certificate_path,
        //    'diagnosing_doctor' => $injuryreport->diagnosing_doctor,
        //    'doctor_affiliation' => $injuryreport->doctor_affiliation,
        //    'doctor_email_of_telno' => $injuryreport->doctor_email_of_telno,
        //    'multiple_injuries_tmp' => $injuryreport->multiple_injuries_tmp,
        //    'circumstances' => $injuryreport->circumstances,
        //    'circumstance_other' => $injuryreport->circumstance_other,
        //    'binding_release' => $injuryreport->binding_release,
        //    'type_of_snow' => $injuryreport->type_of_snow,
        //    'type_of_snow_other' => $injuryreport->type_of_snow_other,
        //    'course_conditions' => $injuryreport->course_conditions,
        //    'course_condition_other' => $injuryreport->course_condition_other,
        //    'weather_conditions' => $injuryreport->weather_conditions,
        //    'wind_conditions' => $injuryreport->wind_conditions,
        //    'video' => $injuryreport->video,
        //    'video_path' => $injuryreport->video_path,
        //    'explain' => $injuryreport->explain,
        //    'way_to_get_video' => $injuryreport->way_to_get_video,
        //    'additional_information' => $injuryreport->additional_information,
        //    //'reserve1' => $injuryreport->reserve1,
        //    //'reserve2' => $injuryreport->reserve2,
        //    //'reserve3' => $injuryreport->reserve3,
        //    //'reserve4' => $injuryreport->reserve4,
        //    //'reserve5' => $injuryreport->reserve5,
        //    //'reserve6' => $injuryreport->reserve6,
        //    //'reserve7' => $injuryreport->reserve7,
        //    'create_time' => $injuryreport->create_time,
        //    'update_time' => $injuryreport->update_time,
        //    'delete_flag' => $injuryreport->delete_flag,
        //]);

        $filename = "";
        if($medical_certificate_file!=null){
            // セッションからストレージのファイルパスを取得
            $medical_certificate_path = session('medical_certificate_file');
            $video_file_path = session('video_file');
            //ddd([$video_file_path, $medical_certificate_path]);

            if ($medical_certificate_path) {
                // ファイルを移動
                $filename = basename($medical_certificate_path);
                Storage::move($medical_certificate_path, 'public/upload/medical_certificate/' . $injuryreport->medical_certificate_path);
                // セッションからファイルパスを削除
                session()->forget('medical_certificate_path');
            }
        }

        if($video_file!=null){
            // セッションからストレージのファイルパスを取得
            $video_file_path = session('video_file');
            if ($video_file_path) {
                // ファイルを移動
                $filename = basename($video_file_path);
                Storage::move($video_file_path, 'public/upload/video/' . $injuryreport->video_path);
                // セッションからファイルパスを削除
                session()->forget('video_file');
            }
        }


        $injuryreport->update();

        //一覧表示画面にリダイレクト
        //return redirect('confirm');
        return view('edited',
        [
            'user' => $user,
            'id' => $cid,
            'injuryreport' => $injuryreport
        ]);
        return view('edited', compact(['id']));
    }

    /**
     */
    public function delete($id){
        $user = Auth::user();
        if($user==null){
            return redirect('/');
        }
        return view('delete', compact(['id']));
    }
}
