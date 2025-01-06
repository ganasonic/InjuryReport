@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    <div class="row">
        @if($mode=='create')
        <h2>傷害情報の登録</h2>
        @elseif($mode=='edit')
        <h2>傷害情報の更新</h2>
        @else
        <h2>傷害情報の確認</h2>
        @endif

        <div id="wizard">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        </div>
        <form id="example-form" action="/register" enctype="multipart/form-data" method="POST" style="">
        @csrf
            <div>
                <h3>報告者情報《Reporterinformation》</h3>
                <section>
                    <label for="email" class="form-label">メールアドレス *</label>
                    <input id="email" name="email" type="text" class="form-control required" value="{{$user->email}}">
                    <label for="reporter_name" class="form-label">Reporter Name：報告者名 *</label>
                    <input id="reporter_name" name="reporter_name" type="text" class="form-control required" value="{{$user->name}}">
                    <label for="reporter_type" class="form-label">Reporter Type：報告者種別 *</label>
                    <select class="form-select mb-4" name="reporter_type" id="form-reporter_type" value="0">
                        @foreach($reporter_types as $reporter_type)
                        <option value="{{$reporter_type->id}}">{{$reporter_type->name}}</option>
                        @endforeach
                    </select>
                    <p>(*) Mandatory</p>
                </section>

                <h3>選手情報《Athlete information》</h3>
                <section>
                    <label for="name" class="form-label">Name：選手名 *<span style="font-size:10pt;">受傷した選手の名前を入力して下さい</span></label>
                    <input id="name" name="name" type="text" class="form-control required" value={{ old('name') }}>
                    <label for="discipline" class="form-label">Discipline：〈競技種目〉 *</label>
                    <select class="form-select mb-4" name="discipline" id="form-discipline">
                        @foreach($disciplines as $discipline)
                        <option value="{{$discipline->id}}">{{$discipline->name_en}} {{$discipline->name}}</option>
                        @endforeach
                    </select>
                    <label for="category" class="form-label">Category：カテゴリー</label>
                    <select class="form-select mb-4" name="category" id="form-category">
                        @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <label for="gender" class="form-label">Gender：性別 *</label>
                    <select class="form-select mb-4" name="gender" id="form-gender">
                        @foreach($genders as $gender)
                        <option value="{{$gender->id}}">{{$gender->name_en}} {{$gender->name}}</option>
                        @endforeach
                    </select>
                    <label for="birth_date" class="form-label">Birth date：生年月日 *</label>
                    <input id="birth_date" name="birth_date" type="date" class="form-control required" value={{ old('birth_date') }}>
                    <label for="team" class="form-label">Team:所属先 *<span style="font-size:10pt;">受傷した選手の所属先を入力して下さい</span></label>
                    <input id="team" name="team" type="text" class="form-control required" value={{ old('team') }}>
                        <p>(*) Mandatory</p>
                </section>

                <h3>イベント情報《Event information》</h3>
                <section>
                    <label for="injured_date" class="form-label">Date：受傷年月日 *<span style="font-size:10pt;">受傷年月日を入力して下さい</span></label>
                    <input id="injured_date" name="injured_date" type="date" class="form-control required" value={{ old('injured_date') }}>
                    <label for="circumstances">circumstances：大会 or 練習 *</label>
                    <select class="form-select mb-4" name="circumstances" id="form-circumstances">
                        @foreach($circumstances as $circumstance)
                        <option value="{{$circumstance->id}}">{{$circumstance->name_en}} {{$circumstance->name}}</option>
                        @endforeach
                    </select>
                    <label for="circumstance_other" class="form-label">その他<span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span></label>
                    <input id="circumstance_other" name="circumstance_other" type="text" class="form-control" value={{ old('circumstance_other') }}>
                    <label for="country" class="form-label">Country：国名 *<span style="font-size:10pt;">受傷した国/町を入力して下さい</span></label>
                    <input id="country" name="country" type="text" class="form-control required" value={{ old('country') }}>
                    <label for="site" class="form-label">Site：会場名<span style="font-size:10pt;">受傷した会場名（○○スキー場など）を入力して下さい</span></label>
                    <input id="site" name="site" type="text" class="form-control required" value={{ old('site') }}>
                    <label for="competition" class="form-label">Competition：大会名</label>
                    <input id="competition" name="competition" type="text" class="form-control" value={{ old('competition') }}>
                    <label for="codex" class="form-label">Codex：コーデックス<span style="font-size:10pt;">大会コードを半角数字4桁で入力して下さい</span></label>
                    <input id="codex" name="codex" type="tel" class="form-control" value={{ old('codex') }}>
                </section>

                <h3>傷害情報《Injury information》</h3>
                <span style="font-size:10pt;">複数の傷害がある場合は一番重篤な傷害の情報を報告してください。</span>
                <section>
                    <label for="body_part_injured" class="form-label">Body part injured：傷害部位 *<span style="font-size:10pt;">受傷部位をリストから選択してください</span></label>
                    <select class="form-select mb-4" name="body_part_injured" id="form-body_part_injured">
                        @foreach($body_part_injureds as $body_part_injured)
                        <option value="{{$body_part_injured->id}}">{{$body_part_injured->name_en}} {{$body_part_injured->name}}</option>
                        @endforeach
                    </select>
                    <label for="side" class="form-label">Side：受傷側 *<span style="font-size:10pt;">受傷部位をリストから選択してください</span></label>
                    <select class="form-select mb-4" name="side" id="form-side">
                        @foreach($sides as $side)
                        <option value="{{$side->id}}">{{$side->name_en}} {{$side->name}}</option>
                        @endforeach
                    </select>
                    <label for="injury_type" class="form-label">Injury type：傷害のタイプ *<span style="font-size:10pt;">傷害のタイプをリストから選択してください</span></label>
                    <select class="form-select mb-4" name="injury_type" id="form-injury_type">
                        @foreach($injury_types as $injury_type)
                        <option value="{{$injury_type->id}}">{{$injury_type->name_en}} {{$injury_type->name}}</option>
                        @endforeach
                    </select>
                    <label for="injury_type_other" class="form-label">その他<span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span></label>
                    <input id="injury_type_other" name="injury_type_other" type="text" class="form-control" value={{ old('injury_type_other') }}>
                    <label for="expected_absence" class="form-label">Expected absence from training and competition：トレーニング及び試合への不参加見込み期間 *</label>
                    <select class="form-select mb-4" name="expected_absence" id="form-expected_absence">
                        @foreach($expected_absences as $expected_absence)
                        <option value="{{$expected_absence->id}}">{{$expected_absence->name_en}} {{$expected_absence->name}}</option>
                        @endforeach
                    </select>
                    <label for="multiple_injuries" class="form-label">複数の傷害（重篤順）<span style="font-size:10pt;">上記以外に複数傷害のある場合、重篤な順に記して下さい。（程度が同じものは、その旨を記載）</span></label>
                    <textarea id="multiple_injuries" name="multiple_injuries" class="form-control">{{ old('multiple_injuries') }}</textarea>
                </section>

                <h3>診察情報（医師による診断）</h3>
                <section>
                    <label for="consultation" class="form-label">医師による診察の有無 *</label>
                    <select class="form-select mb-4" name="consultation" id="form-consultation">
                        @foreach($consultations as $consultation)
                        <option value="{{$consultation->id}}">{{$consultation->name_en}} {{$consultation->name}}</option>
                        @endforeach
                    </select>
                    <label for="medical_certificate_path" class="form-label">診断書の写しがある場合はアップロードしてください。</label>
                    <input id="medical_certificate_path" name="medical_certificate_path" type="file" class="form-control" value={{ old('medical_certificate_path') }}>
                    <label for="specific_diagnosis" class="form-label">Specific diagnosis：具体的な診断名 *<span style="font-size:10pt;">＊ここには医師の診断名を記入して下さい</span></label>
                    <input id="specific_diagnosis" name="specific_diagnosis" type="text" class="form-control required" value={{ old('specific_diagnosis') }}>
                    <label for="diagnosing_doctor" class="form-label">診断医名<span style="font-size:10pt;">診断した医師の名前を入力して下さい</span></label>
                    <input id="diagnosing_doctor" name="diagnosing_doctor" type="text" class="form-control" value={{ old('diagnosing_doctor') }}>
                    <label for="doctor_affiliation" class="form-label">所属<span style="font-size:10pt;">診断した医師の所属先を入力して下さい</span></label>
                    <input id="doctor_affiliation" name="doctor_affiliation" type="text" class="form-control" value={{ old('doctor_affiliation') }}>
                    <label for="doctor_email_of_telno" class="form-label">電話orE-mail<span style="font-size:10pt;">診断した医師の連絡先を入力して下さい</span></label>
                    <input id="doctor_email_of_telno" name="doctor_email_of_telno" type="text" class="form-control" value={{ old('doctor_email_of_telno') }}>
                    <label for="multiple_injuries" class="form-label">複数の傷害（重篤順）<span style="font-size:10pt;colo:red;">冗長質問？今回の原因で複数の傷害を生じている場合、ケガを重篤な順に記して下さい。（程度が同じものは、その旨を記載）</span></label>
                    <textarea id="multiple_injuries_tmp" name="multiple_injuries_tmp" class="form-control">{{ old('multiple_injuries_tmp') }}</textarea>
                </section>

                <h3>受傷環境《Injury circumstances》</h3>
                <span style="font-size:10pt;">受傷時の環境について入力して下さい</span>
                <section>
                    <label for="binding_release" class="form-label">Binding Release（受傷時ビンディング解放の有無）</label>
                    <select class="form-select mb-4" name="binding_release" id="form-binding_release">
                        @foreach($binding_releases as $binding_release)
                        <option value="{{$binding_release->id}}">{{$binding_release->name_en}} {{$binding_release->name}}</option>
                        @endforeach
                    </select>
                    <label for="weather_conditions" class="form-label">Weather conditions：気象状況<span style="font-size:10pt;">（複数選択可）</span></label>
                    <select class="form-select mb-4" name="weather_conditions[]" id="form-weather_conditions" multiple class="form-control required">
                        @foreach($weather_conditions as $weather_condition)
                        <option value="{{$weather_condition->name_en}} {{$weather_condition->name}}">{{$weather_condition->name_en}} {{$weather_condition->name}}</option>
                        @endforeach
                    </select>
                    <label for="type_of_snow" class="form-label">Type of snow：雪質、地面</label>
                    <select class="form-select mb-4" name="type_of_snow" id="form-type_of_snow">
                        @foreach($type_of_snows as $type_of_snow)
                        <option value="{{$type_of_snow->id}}">{{$type_of_snow->name_en}} {{$type_of_snow->name}}</option>
                        @endforeach
                    </select>
                    <label for="type_of_snow_other" class="form-label">その他<span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span></label>
                    <input id="type_of_snow_other" name="type_of_snow_other" type="text" class="form-control" value={{ old('type_of_snow_other') }}>
                    <label for="course_conditions" class="form-label">Course conditions：コースの状況<span style="font-size:10pt;">（複数選択可）</span></label>
                    <select class="form-select mb-4" name="course_conditions[]" id="form-course_conditions" multiple class="form-control required">
                        @foreach($course_conditions as $course_condition)
                        <option value="{{$course_condition->name_en}} {{$course_condition->name}}">{{$course_condition->name_en}} {{$course_condition->name}}</option>
                        @endforeach
                    </select>
                    <label for="course_condition_other" class="form-label">その他<span style="font-size:10pt;">その他を選択した場合は、具体的に入力してください</span></label>
                    <input id="course_condition_other" name="course_condition_other" type="text" class="form-control" value={{ old('course_condition_other') }}>
                    <label for="wind_conditions" class="form-label">Wind conditions：風の状況</label>
                    <select class="form-select mb-4" name="wind_conditions" id="form-wind_conditions">
                        @foreach($wind_conditions as $wind_condition)
                        <option value="{{$wind_condition->id}}">{{$wind_condition->name_en}} {{$wind_condition->name}}</option>
                        @endforeach
                    </select>
                </section>

                <h3>映像《Video》</h3>
                <span style="font-size:10pt;">受傷時の映像について入力してください</span>
                <section>
                    <label for="video" class="form-label">Video：映像の有無<span style="font-size:10pt;">傷害情報を得るのに有効なビデオはありますか？</span></label>
                    <select class="form-select mb-4" name="video" id="form-video" class="form-control required">
                        @foreach($videos as $video)
                        <option value="{{$video->id}}">{{$video->name_en}} {{$video->name}}</option>
                        @endforeach
                    </select>
                    <label for="video_path" class="form-label">映像をアップロードしてください。</label>
                    <input id="video_path" name="video_path" type="file" class="form-control" value={{ old('video_path') }}>
                    <label for="explain" class="form-label">Explain  上記に関する説明</label>
                    <textarea id="explain" name="explain" class="form-control">{{ old('explain') }}</textarea>
                    <label for="way_to_get_video" class="form-label">上記ビデオのコピー入手方法があれば記して下さい</label>
                    <textarea id="way_to_get_video" name="way_to_get_video" class="form-control">{{ old('way_to_get_video') }}</textarea>
                </section>

                <h3>その他《Other comments》</h3>
                <section>
                    <label for="additional_information" class="form-label">気付いた等、補足情報があれば記入してください</label>
                    <textarea id="additional_information" name="additional_information" class="form-control">{{ old('additional_information') }}</textarea>
                </section>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                <a href="/" class="btn btn-success">{{ __('戻る') }}</a>
                </div>
                <div class="col-6 text-end">
                <button type="submit" class="btn btn-primary" >{{ __('登録') }}</button>
                </div>
            </div>

        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
        <script>
            var form = $("#example-form");
            form.validate({
                errorPlacement: function errorPlacement(error, element) { element.before(error); },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });
            form.children("div").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinishing: function (event, currentIndex)
                {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    alert("Submitted!");
                }
            });



        </script>


    </div>
    @else
    @endauth
</div>
@endsection
