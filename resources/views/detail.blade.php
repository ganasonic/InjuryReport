@extends('layouts.app')

@section('content')
<style>
    .small-image {
        width: 150px; /* 画像の幅を指定 */
        height: auto; /* アスペクト比を維持 */
    }
    .large-image {
            display: none;
            position: absolute;
            width: 600px;
            height: auto;
            z-index: 10;
            border: 1px solid #ccc;
            background-color: #fff;
        }
</style>
<div class="container">
    <div class="row">
        @if($mode=='view')
        <h2>傷害情報の確認</h2>
        @else
        <h2>傷害情報の編集</h2>
        @endif

        @if($mode=='view')
        <form action="{{ route('toggle', $injuryreport->id) }}" method="POST">
            <div class="row mt-3">
                <div class="col-6">
                    <button onclick="window.history.back()" class="btn btn-success">{{ __('戻る') }}</button>
                </div>
                <div class="col-6 text-end">
                    @csrf
                    @if($user->role>0)
                        <input type="hidden" name="mode" value="{{ $mode }}">
                        <button id="editButton" type="submit" class="btn btn-success">編集</button>
                    @else
                        @if($user->email==$injuryreport->email)
                            <input type="hidden" name="mode" value="{{ $mode }}">
                            <button id="editButton" type="submit" class="btn btn-success">編集</button>
                        @endif
                    @endif
                </div>
            </div>
        </form>
        @else
            <div class="row mt-3">
                <div class="col-6">
                    <button onclick="window.history.back()" class="btn btn-success">{{ __('戻る') }}</button>
                </div>
                <div class="col-6 text-end">
                    @csrf
                    <button id="saveButton" type="submit" class="btn btn-success">保存</button>
                </div>
            </div>
        @endif
        <div class="row mt-3"></div>

        <div id="wizard">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        </div>
        @if($mode=='edit')
        <form id="example-form" action="/edit/{{ $injuryreport->id }}" enctype="multipart/form-data" method="POST" style="">
        @endif
        <div>
            <h3>報告者情報《Reporterinformation》</h3>
            <section>
                <label for="email" class="form-label">メールアドレス *</label>
                <input id="email" name="email" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->email }}">
                <label for="reporter_name" class="form-label">Reporter Name：報告者名 *</label>
                <input id="reporter_name" name="reporter_name" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->reporter_name }}">
                <label for="reporter_type" class="form-label">Reporter Type：報告者種別 *</label>
                @if($mode=='view')
                <input id="reporter_type" name="reporter_type" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $reporter_types[$injuryreport->reporter_type-1]->name_en.' '.$reporter_types[$injuryreport->reporter_type-1]->name }}">
                @else
                <select class="form-select mb-4" name="reporter_type" id="form-reporter_type" value="0">
                    @foreach($reporter_types as $reporter_type)
                    <option value="{{$reporter_type->id}}" @if($injuryreport->reporter_type==$reporter_type->id) selected @endif>{{$reporter_type->name}}</option>
                    @endforeach
                </select>
                @endif
            </section>

            <h3>選手情報《Athlete information》</h3>
            <section>
                <label for="name" class="form-label">Name：選手名 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷した選手の名前を入力して下さい</span>
                    @endif
                </label>
                <input id="name" name="name" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->name }}">
                <label for="discipline" class="form-label">Discipline：〈競技種目〉 *</label>
                @if($mode=='view')
                <input id="discipline" name="discipline" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $disciplines[$injuryreport->discipline-1]->name_en.' '.$disciplines[$injuryreport->discipline-1]->name }}">
                @else
                <select class="form-select mb-4" name="discipline" id="form-discipline">
                    @foreach($disciplines as $discipline)
                    <option value="{{$discipline->id}}" @if($injuryreport->discipline==$discipline->id) selected @endif>{{$discipline->name_en}} {{$discipline->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="category" class="form-label">Category：カテゴリー</label>
                @if($mode=='view')
                <input id="category" name="category" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $categorys[$injuryreport->category]->name }}">
                @else
                <select class="form-select mb-4" name="category" id="form-category">
                    @foreach($categorys as $category)
                    <option value="{{$category->id}}" @if($injuryreport->category==$category->id) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="gender" class="form-label">Gender：性別 *</label>
                @if($mode=='view')
                <input id="gender" name="gender" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $genders[$injuryreport->gender-1]->name_en.' '.$genders[$injuryreport->gender-1]->name }}">
                @else
                <select class="form-select mb-4" name="gender" id="form-gender">
                    @foreach($genders as $gender)
                    <option value="{{$gender->id}}" @if($injuryreport->gender==$gender->id) selected @endif>{{$gender->name_en}} {{$gender->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="birth_date" class="form-label">Birth date：生年月日 *</label>
                <input id="birth_date" name="birth_date" type="date" @if($mode == 'view') readonly @endif class="form-control required" value="{{ date('Y-m-d', strtotime($injuryreport->birth_date)) }}">
                <label for="team" class="form-label">Team:所属先 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷した選手の所属先を入力して下さい</span>
                    @endif
                </label>
                <input id="team" name="team" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->team }}">
            </section>

            <h3>イベント情報《Event information》</h3>
            <section>
                <label for="injured_date" class="form-label">Date：受傷年月日 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷年月日を入力して下さい</span>
                    @endif
                </label>
                <input id="injured_date" name="injured_date" type="date" @if($mode == 'view') readonly @endif class="form-control required" value="{{ date('Y-m-d', strtotime($injuryreport->injured_date)) }}">
                <label for="circumstances" class="form-label">circumstances：大会 or 練習 *</label>
                @if($mode=='view')
                <input id="circumstances" name="circumstances" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $circumstances[$injuryreport->circumstances-1]->name_en.' '.$circumstances[$injuryreport->circumstances-1]->name }}">
                @else
                <select class="form-select mb-4" name="circumstances" id="form-circumstances">
                    @foreach($circumstances as $circumstance)
                    <option value="{{$circumstance->id}}" @if($injuryreport->circumstances==$circumstance->id) selected @endif>{{$circumstance->name_en}} {{$circumstance->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="circumstance_other" class="form-label">その他
                    @if($mode=='edit')
                    <span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span>
                    @endif
                </label>
                <input id="circumstance_other" name="circumstance_other" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->circumstance_other }}">
                <label for="country" class="form-label">Country：国名 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷した国/町を入力して下さい</span>
                    @endif
                </label>
                <input id="country" name="country" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->country }}">
                <label for="site" class="form-label">Site：会場名
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷した会場名（○○スキー場など）を入力して下さい</span>
                    @endif
                </label>
                <input id="site" name="site" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->site }}">
                <label for="competition" class="form-label">Competition：大会名</label>
                <input id="competition" name="competition" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->competition }}">
                <label for="codex" class="form-label">Codex：コーデックス
                    @if($mode=='edit')
                    <span style="font-size:10pt;">大会コードを半角数字4桁で入力して下さい</span>
                    @endif
                </label>
                <input id="codex" name="codex" type="tel" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->codex }}">
            </section>

            <h3>傷害情報《Injury information》</h3>
            @if($mode=='edit')
            <span style="font-size:10pt;">複数の傷害がある場合は一番重篤な傷害の情報を報告してください。</span>
            @endif
            <section>
                <label for="body_part_injured" class="form-label">Body part injured：傷害部位 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷部位をリストから選択してください</span>
                    @endif
                </label>
                @if($mode=='view')
                <input id="body_part_injured" name="body_part_injured" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $body_part_injureds[$injuryreport->body_part_injured-1]->name_en.' '.$body_part_injureds[$injuryreport->body_part_injured-1]->name }}">
                @else
                <select class="form-select mb-4" name="body_part_injured" id="form-body_part_injured">
                    @foreach($body_part_injureds as $body_part_injured)
                    <option value="{{$body_part_injured->id}}" @if($injuryreport->body_part_injured==$body_part_injured->id) selected @endif>{{$body_part_injured->name_en}} {{$body_part_injured->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="side" class="form-label">Side：受傷側 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">受傷部位をリストから選択してください</span>
                    @endif
                </label>
                @if($mode=='view')
                <input id="side" name="side" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $sides[$injuryreport->side-1]->name_en.' '.$sides[$injuryreport->side-1]->name }}">
                @else
                <select class="form-select mb-4" name="side" id="form-side">
                    @foreach($sides as $side)
                    <option value="{{$side->id}}" @if($injuryreport->side==$side->id) selected @endif>{{$side->name_en}} {{$side->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="injury_type" class="form-label">Injury type：傷害のタイプ *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">傷害のタイプをリストから選択してください</span>
                    @endif
                </label>
                @if($mode=='view')
                <input id="injury_type" name="injury_type" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injury_types[$injuryreport->injury_type-1]->name_en.' '.$injury_types[$injuryreport->injury_type-1]->name }}">
                @else
                <select class="form-select mb-4" name="injury_type" id="form-injury_type">
                    @foreach($injury_types as $injury_type)
                    <option value="{{$injury_type->id}}" @if($injuryreport->injury_type==$injury_type->id) selected @endif>{{$injury_type->name_en}} {{$injury_type->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="injury_type_other" class="form-label">その他
                    @if($mode=='edit')
                    <span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span>
                    @endif
                </label>
                <input id="injury_type_other" name="injury_type_other" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->injury_type_other }}">
                <label for="expected_absence" class="form-label">Expected absence from training and competition：トレーニング及び試合への不参加見込み期間 *</label>
                @if($mode=='view')
                <input id="expected_absence" name="expected_absence" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $expected_absences[$injuryreport->expected_absence-1]->name_en.' '.$expected_absences[$injuryreport->expected_absence-1]->name }}">
                @else
                <select class="form-select mb-4" name="expected_absence" id="form-expected_absence">
                    @foreach($expected_absences as $expected_absence)
                    <option value="{{$expected_absence->id}}" @if($injuryreport->expected_absence==$expected_absence->id) selected @endif>{{$expected_absence->name_en}} {{$expected_absence->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="multiple_injuries" class="form-label">複数の傷害（重篤順）
                    @if($mode=='edit')
                    <span style="font-size:10pt;">上記以外に複数傷害のある場合、重篤な順に記して下さい。（程度が同じものは、その旨を記載）</span>
                    @endif
                </label>
                <textarea id="multiple_injuries" name="multiple_injuries" class="form-control" @if($mode == 'view') readonly @endif>{{ $injuryreport->multiple_injuries }}</textarea>
            </section>

            <h3>診察情報（医師による診断）</h3>
            <section>
                <label for="consultation" class="form-label">医師による診察の有無 *</label>
                @if($mode=='view')
                <input id="consultation" name="consultation" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $consultations[$injuryreport->consultation]->name_en.' '.$consultations[$injuryreport->consultation]->name }}">
                @else
                <select class="form-select mb-4" name="consultation" id="form-consultation">
                    @foreach($consultations as $consultation)
                    <option value="{{$consultation->id}}" @if($injuryreport->consultation==$consultation->id) selected @endif>{{$consultation->name_en}} {{$consultation->name}}</option>
                    @endforeach
                </select>
                @endif
                @if($mode=='view')
                <label for="medical_certificate_path" class="form-label">診断書の写し</label>
                @else
                <label for="medical_certificate_path" class="form-label">診断書の写しがある場合はアップロードしてください。</label>
                @endif
                <input id="medical_certificate_path_tmp" name="medical_certificate_path" type="text" class="form-control" @if($mode == 'view') readonly @endif  value="{!! $injuryreport->medical_certificate_path !!}">
                @if($mode=='view')
                <div>
                    {!!$medicalcertificatelink!!}
                </div>
                @else
                <input id="medical_certificate_path" name="medical_certificate_path" type="file" class="form-control">
                @endif

                <label for="specific_diagnosis" class="form-label">Specific diagnosis：具体的な診断名 *
                    @if($mode=='edit')
                    <span style="font-size:10pt;">＊ここには医師の診断名を記入して下さい</span>
                    @endif
                </label>
                <input id="specific_diagnosis" name="specific_diagnosis" type="text" @if($mode == 'view') readonly @endif class="form-control required" value="{{ $injuryreport->specific_diagnosis }}">
                <label for="diagnosing_doctor" class="form-label">診断医名
                    @if($mode=='edit')
                    <span style="font-size:10pt;">診断した医師の名前を入力して下さい</span>
                    @endif
                </label>
                <input id="diagnosing_doctor" name="diagnosing_doctor" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->diagnosing_doctor }}">
                <label for="doctor_affiliation" class="form-label">所属
                    @if($mode=='edit')
                    <span style="font-size:10pt;">診断した医師の所属先を入力して下さい</span>
                    @endif
                </label>
                <input id="doctor_affiliation" name="doctor_affiliation" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->doctor_affiliation }}">
                <label for="doctor_email_of_telno" class="form-label">電話orE-mail
                    @if($mode=='edit')
                    <span style="font-size:10pt;">診断した医師の連絡先を入力して下さい</span>
                    @endif
                </label>
                <input id="doctor_email_of_telno" name="doctor_email_of_telno" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->doctor_email_of_telno }}">
                <label for="multiple_injuries" class="form-label">複数の傷害（重篤順）
                    @if($mode=='edit')
                    <span style="font-size:10pt;colo:red;">冗長質問？今回の原因で複数の傷害を生じている場合、ケガを重篤な順に記して下さい。（程度が同じものは、その旨を記載）</span>
                    @endif
                </label>
                <textarea id="multiple_injuries_tmp" name="multiple_injuries_tmp" class="form-control" @if($mode == 'view') readonly @endif>{{ $injuryreport->multiple_injuries_tmp }}</textarea>
            </section>

            <h3>受傷環境《Injury circumstances》</h3>
            @if($mode=='edit')
            <span style="font-size:10pt;">受傷時の環境について入力して下さい</span>
            @endif
            <section>
                <label for="binding_release" class="form-label">Binding Release（受傷時ビンディング解放の有無）</label>
                @if($mode=='view')
                <input id="binding_release" name="binding_release" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $binding_releases[$injuryreport->binding_release]->name_en.' '.$binding_releases[$injuryreport->binding_release]->name }}">
                @else
                <select class="form-select mb-4" name="binding_release" id="form-binding_release">
                    @foreach($binding_releases as $binding_release)
                    <option value="{{$binding_release->id}}" @if($injuryreport->binding_release==$binding_release->id) selected @endif>{{$binding_release->name_en}} {{$binding_release->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="weather_conditions" class="form-label">Weather conditions：気象状況</label>
                @if($mode=='view')
                <input id="video" name="video" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->weather_conditions }}">
                @else
@php
    // $injuryreport->weather_conditionsの値をカンマで分割して配列にする
    $selected_weather_condition = explode(',', $injuryreport->weather_conditions);
@endphp
                <select class="form-select mb-4" name="weather_conditions[]" id="form-weather_conditions" multiple class="form-control required">
                    @foreach($weather_conditions as $weather_condition)
@php
    // オプションが選択されているかどうかを確認
    $weather_condition_value = $weather_condition->name_en.' '.$weather_condition->name;
    $isSelectedWeather = in_array($weather_condition_value, $selected_weather_condition);
@endphp
                    <option value="{{$weather_condition->name_en}} {{$weather_condition->name}}" {{ $isSelectedWeather ? 'selected' : '' }}>
                        {{$weather_condition->name_en}} {{$weather_condition->name}}
                    </option>
                    @endforeach
                </select>
                @endif
                <label for="type_of_snow" class="form-label">Type of snow：雪質、地面</label>
                @if($mode=='view')
                <input id="type_of_snow" name="type_of_snow" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $type_of_snows[$injuryreport->type_of_snow-1]->name_en.' '.$type_of_snows[$injuryreport->type_of_snow-1]->name }}">
                @else
                <select class="form-select mb-4" name="type_of_snow" id="form-type_of_snow">
                    @foreach($type_of_snows as $type_of_snow)
                    <option value="{{$type_of_snow->id}}" @if($injuryreport->type_of_snow==$type_of_snow->id) selected @endif>{{$type_of_snow->name_en}} {{$type_of_snow->name}}</option>
                    @endforeach
                </select>
                @endif
                <label for="type_of_snow_other" class="form-label">その他
                    @if($mode=='edit')
                    <span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span>
                    @endif
                </label>
                <input id="type_of_snow_other" name="type_of_snow_other" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->type_of_snow_other }}">
                <label for="course_conditions" class="form-label">Course conditions：コースの状況</label>
                @if($mode=='view')
                <input id="course_conditions" name="course_conditions" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->course_conditions }}">
                @else
@php
    // $injuryreport->course_conditions
    $selected_course_condition = explode(',', $injuryreport->course_conditions);
@endphp
                <select class="form-select mb-4" name="course_conditions[]" id="form-course_conditions" multiple class="form-control required">
                    @foreach($course_conditions as $course_condition)
@php
    // オプションが選択されているかどうかを確認
    $course_condition_value = $course_condition->name_en.' '.$course_condition->name;
    $isSelectedCourse = false;
    foreach($selected_course_condition as $selected_coursecondition){
        if($course_condition_value==trim($selected_coursecondition)){
            $isSelectedCourse = true;
            break;
        }
    }
@endphp
                    <option value="{{$course_condition->name_en}} {{$course_condition->name}}" {{ $isSelectedCourse ? 'selected' : '' }}>
                        {{$course_condition->name_en}} {{$course_condition->name}}
                    </option>
                    @endforeach
                </select>
                @endif
                <label for="course_condition_other" class="form-label">その他
                    @if($mode=='edit')
                    <span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span>
                    @endif
                </label>
                <input id="course_condition_other" name="course_condition_other" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->course_condition_other }}">
                <label for="wind_conditions" class="form-label">Wind conditions：風の状況</label>
                @if($mode=='view')
                <input id="wind_conditions" name="wind_conditions" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $wind_conditions[$injuryreport->wind_conditions]->name_en.' '.$wind_conditions[$injuryreport->wind_conditions]->name }}">
                @else
                <select class="form-select mb-4" name="wind_conditions" id="form-wind_conditions">
                    @foreach($wind_conditions as $wind_condition)
                    <option value="{{$wind_condition->id}}" @if($injuryreport->wind_conditions==$wind_condition->id) selected @endif>{{$wind_condition->name_en}} {{$wind_condition->name}}</option>
                    @endforeach
                </select>
                @endif
            </section>

            <h3>映像《Video》</h3>
            @if($mode=='edit')
            <span style="font-size:10pt;">受傷時の映像について入力してください</span>
            @endif
            <section>
                <label for="video" class="form-label">Video：映像の有無
                    @if($mode=='edit')<span style="font-size:10pt;">傷害情報を得るのに有効なビデオはありますか？</span>
                    @endif
                </label>
                @if($mode=='view')
                <input id="video" name="video" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $videos[$injuryreport->video-1]->name_en.' '.$videos[$injuryreport->video-1]->name }}">
                @else
                <select class="form-select mb-4" name="video" id="form-video" class="form-control required">
                    @foreach($videos as $video)
                    <option value="{{$video->id}}" @if($injuryreport->video==$video->id) selected @endif>{{$video->name_en}} {{$video->name}}</option>
                    @endforeach
                </select>
                @endif
                @if($mode=='view')
                <label for="video_path" class="form-label">映像ファイル名など</label>
                @else
                <label for="video_path" class="form-label">映像をアップロードしてください。</label>
                @endif
                <input id="video_path_tmp" name="video_path" type="text" class="form-control" @if($mode == 'view') readonly @endif value="{{ $injuryreport->video_path }}">
                {!! $embedCode !!}
                @if($mode=='edit')
                <input id="video_path" name="video_path" type="file">
                @endif
                <label for="explain" class="form-label">Explain  上記に関する説明</label>
                <textarea id="explain" name="explain" class="form-control" @if($mode == 'view') readonly @endif>{{ $injuryreport->explain }}</textarea>
                @if($mode=='view')
                <label for="way_to_get_video" class="form-label">ビデオのコピー入手方法</label>
                @else
                <label for="way_to_get_video" class="form-label">上記ビデオのコピー入手方法があれば記して下さい</label>
                @endif
                <textarea id="way_to_get_video" name="way_to_get_video" class="form-control" @if($mode == 'view') readonly @endif>{{ $injuryreport->way_to_get_video }}</textarea>
            </section>

            <h3>その他《Other comments》</h3>
            <section>
                @if($mode=='view')
                <label for="additional_information" class="form-label">気付いた等、補足情報</label>
                @else
                <label for="additional_information" class="form-label">気付いた等、補足情報があれば記入してください </label>
                @endif
                <textarea id="additional_information" name="additional_information" class="form-control" @if($mode == 'view') readonly @endif>{{ $injuryreport->additional_information }}</textarea>
            </section>
        </div>
        @if($mode=='edit')
        <div class="row mt-3">
            <div class="col-6">
                <button onclick="window.history.back()" class="btn btn-success">{{ __('戻る') }}</button>
            </div>
            <div class="col-6 text-end">
                @csrf
                <button id="saveButton" type="submit" class="btn btn-success">保存</button>
            </div>
        </div>
        </form>
        @endif

        @if($mode=='view')
        <form action="{{ route('toggle', $injuryreport->id) }}" method="POST">
            <div class="row mt-3">
                <div class="col-6">
                <button onclick="window.history.back()" class="btn btn-success">{{ __('戻る') }}</button>
                </div>
                <div class="col-6 text-end">
                    @csrf
                    @if($user->role>0)
                        <input type="hidden" name="mode" value="{{ $mode }}">
                        <button id="editButton" type="submit" class="btn btn-success">編集</button>
                    @else
                        @if($user->email==$injuryreport->email)
                            <input type="hidden" name="mode" value="{{ $mode }}">
                            <button id="editButton" type="submit" class="btn btn-success">編集</button>
                        @endif
                    @endif
                </div>
            </div>
        </form>
        @endif
    </div>
</div>

<script>
        document.getElementById('thumbnail').addEventListener('mouseover', function() {
            document.getElementById('largeImage').style.display = 'block';
        });

        document.getElementById('thumbnail').addEventListener('mouseout', function() {
            document.getElementById('largeImage').style.display = 'none';
        });

        document.getElementById('thumbnail').addEventListener('load', function() {
            document.getElementById('largeImage').style.display = 'none';
        });
    </script>
@endsection

