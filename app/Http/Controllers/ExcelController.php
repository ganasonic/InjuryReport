<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\SajInjuryReport;
use Illuminate\Support\Facades\DB;//重要

class ExcelController extends Controller
{
    public $COLUMNNAME = array(
        'id'=>'ID',
        'email'=>'メールアドレス',
        'score'=>'仮',
        'reporter_type'=>'報告者種別',
        'reporter_name'=>'報告者名',
        'discipline'=>'〈競技種目〉',
        'site'=>'会場名',
        'country'=>'国名',
        'category'=>'カテゴリー',
        'competition'=>'大会名',
        'codex'=>'コーデックス',
        'injured_date'=>'受傷年月日',
        'name'=>'選手名',
        'gender'=>'性別',
        'birth_date'=>'生年月日',
        'team'=>'所属先',
        'body_part_injured'=>'傷害部位',
        'injury_type'=>'傷害のタイプ',
        'injury_type_other'=>'その他',
        'side'=>'受傷側',
        'expected_absence'=>'トレーニング及び試合への不参加見込み期間',
        'multiple_injuries'=>'複数の傷害（重篤順）',
        'consultation'=>'医師による診察の有無',
        //'body_part_injured_2'=>'傷害部位 2',
        //'injury_type_2'=>'傷害のタイプ 2',
        //'injury_type_other_2'=>'その他 2',
        //'side_2'=>'受傷側 2',
        'specific_diagnosis'=>'具体的な診断名',
        'medical_certificate_path'=>'診断書のパス',
        'diagnosing_doctor'=>'診断医名',
        'doctor_affiliation'=>'所属',
        'doctor_email_of_telno'=>'電話orE-mail',
        'multiple_injuries_tmp'=>'複数の傷害（重篤順）',
        'circumstances'=>'大会 or 練習',
        'circumstance_other'=>'大会 or 練習その他',
        'binding_release'=>'受傷時ビンディング解放の有無',
        'type_of_snow'=>'雪質、地面',
        'type_of_snow_other'=>'大会 or 練習その他',
        'course_conditions'=>'コースの状況',
        'course_condition_other'=>'大会 or 練習その他',
        'weather_conditions'=>'気象状況',
        'wind_conditions'=>'風の状況',
        'video'=>'映像の有無',
        'video_path'=>'映像パス',
        'explain'=>'Explain 説明',
        'way_to_get_video'=>'ビデオのコピー入手方法',
        'additional_information'=>'気付いた等、補足情報',
        'reserve1'=>'その他',
        'reserve2'=>'その他',
        'reserve3'=>'その他',
        'reserve4'=>'その他',
        'reserve5'=>'その他',
        'reserve6'=>'その他',
        'reserve7'=>'その他',
        'create_time'=>'作成日',
        'update_time'=>'更新日',
        'delete_flag'=>'削除フラグ',
    );
       //

    public function filterdownload(Request $request) {
        $COLUMNNAME = $this->COLUMNNAME;

        $columns = (new SajInjuryReport)->getTableColumns();

        $downloading_columns = [];
        $header_columns = [];
        foreach($columns as $column) {

            //if(in_array($column, $request->columns)) {

                $downloading_columns[] = $column;
                $header_columns[] = $COLUMNNAME[$column];

            //}

        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $downloading_data = [];

        $columns = "";
        foreach($downloading_columns as $column) {

            $columns = $columns  . "'". $column. "'". ',';

        }
        $columns = substr($columns, 0, -1);
        //ddd('実装中',$columns);

        $obj=SajInjuryReport::select($downloading_columns);
        //全部取得
        //$injuryreports = SajInjuryReport::all(); 
        $injuryreports = SajInjuryReport::orderBy('injured_date', 'desc');

        //選択状態
        $gender_no = $request->input('gender');
        $discipline_no = $request->input('discipline');
        $body_part_injured_no = $request->input('body_part_injured');

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
    
        $downloadings = $injuryreports->get();
        //ddd($downloadings);
        //$downloadings = $downloading_data->all();
        $downloading_data = [];
        //ヘッダーを挿入
        $downloading_data[] = (array)$header_columns;
        foreach($downloadings as $report){
            //$downloading_data[] = (array)$report;
            $downloading_data[] = [
                $report->id,
                $report->email,
                $report->reporter_type,
                $report->reporter_name,
                $report->discipline,
                $report->site,
                $report->country,
                $report->category,
                $report->competition,
                $report->codex,
                $report->injured_date,
                $report->name,
                $report->gender,
                $report->birth_date,
                $report->team,
                $report->body_part_injured,
                $report->injury_type,
                $report->injury_type_other,
                $report->side,
                $report->expected_absence,
                $report->multiple_injuries,
                $report->consultation,
                $report->specific_diagnosis,
                $report->medical_certificate_path,
                $report->diagnosing_doctor,
                $report->doctor_affiliation,
                $report->doctor_email_of_telno,
                $report->multiple_injuries_tmp,
                $report->circumstances,
                $report->circumstance_other,
                $report->binding_release,
                $report->type_of_snow,
                $report->type_of_snow_other,
                $report->course_conditions,
                $report->course_condition_other,
                $report->weather_conditions,
                $report->wind_conditions,
                $report->video,
                $report->video_path,
                $report->explain,
                $report->way_to_get_video,
                $report->additional_information,
                '',//r1
                '',//r2
                '',//r3
                '',//r4
                '',//r5
                '',//r6
                '',//r7
                $report->create_time,
                $report->update_time,
                '',//del
            ];
        }
        //ddd($downloading_data);
        //$sheet->fromArray($downloading_data, null, 'A1');

        $sheet->fromArray($downloading_data, null, 'A1');

        // 現在の日付と時刻を取得する例
        $postfix = date('Ymd');
        $writer = new Xlsx($spreadsheet);
        $fileName = 'injury_reports_' . $postfix . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
        //$writer = new Xlsx($spreadsheet);
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="'. $filename .'"');
        //$writer->save('php://output');

    }
}
