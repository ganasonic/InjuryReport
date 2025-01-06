@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>傷害情報の一覧表示</h1>

        <h3>{{$user->name}}</h3>
        <form id="search">
        <h3>{{$totalReports}}件</h3>
            <!--検索-->
            <div class="row">
                <div class="col-3">
                    <label for="gender" class="form-label">Gender：性別 *</label>
                    <select class="form-select mb-4" name="gender" id="form-gender">
                        <option value="0"></option>
                        @foreach($genders as $gender)
                        <option value="{{$gender->id}}" @if($gender_no==$gender->id) selected @endif>{{$gender->name_en}} {{$gender->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <input type="checkbox" class="form-check-input" name="has_medical_certificate" id="has_medical_certificate">
                    <label class="form-check-label" for="has_medical_certificate">診断書有り</label>
                </div>

                <div class="col-3">
                    <input type="checkbox" class="form-check-input" name="has_video" id="has_video">
                    <label class="form-check-label" for="has_video">映像有り</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="discipline" class="form-label">Discipline：〈競技種目〉</label>
                    <select class="form-select mb-4" name="discipline" id="form-discipline">
                        <option value="0"></option>
                        @foreach($disciplines as $discipline)
                        <option value="{{$discipline->id}}" @if($discipline_no==$discipline->id) selected @endif>{{$discipline->name_en}} {{$discipline->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="body_part_injured" class="form-label">Body part injured：傷害部位</label>
                    <select class="form-select mb-4" name="body_part_injured" id="form-body_part_injured">
                        <option value="0"></option>
                        @foreach($body_part_injureds as $body_part_injured)
                        <option value="{{$body_part_injured->id}}" @if($body_part_injured_no==$body_part_injured->id) selected @endif>{{$body_part_injured->name_en}} {{$body_part_injured->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <!--検索-->
                    <button id="search" type="submit" formaction="{{ route('search') }}" formmethod="GET" class="btn btn-primary" >検索</button>
                </div>
                <div class="col-6 text-end">
                    @if($user->role>0)
                    @csrf
                    <button id="download" type="submit" formaction="{{ route('download') }}" formmethod="POST" class="btn btn-success">{{ __('EXCEL') }}</button>
                    @endif
                </div>
            </div>

        </form>
            
        <div class="fixed-header-table-container mt-3">
            <div class="fixed-header-table-wrapper" id="tableContainer">
                <table class="table table-striped fixed-header-table">
                    <thead>
                        <tr>
                        <th style="width:100px">受傷年月日</th>
                        <th style="width:100px">報告者名</th>
                        <th style="width:200px">競技種目</th>
                        <th style="width:100px">選手名</th>
                        <th style="width:160px">傷害部位</th>
                        <th style="width:200px">傷害のタイプ</th>
                        <th style="width:100px">映像の有無</th>

                        @if($user->role>0)
                        <th style="width:100px">詳細</th>
                        @endif
                        @if($user->role>1)
                        <th style="width:100px">削除</th>
                        @endif

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        @foreach($injuryreports as $injuryreport)
                        @if(true)
                        <tr style="height:40pt;">
                        @else
                        <tr style="height:60pt;">
                        @endif
                            <!--
                            <td style="width:100px">{{$injuryreport->injured_date}}</td>
                            -->
                            <td style="width:100px">{{$injuryreport->formatted_injured_date}}</td>
                            <td style="width:100px">{{$injuryreport->reporter_name}}</td>
                            <td style="width:200px">{{$disciplines[$injuryreport->discipline-1]->name}}</td>
                            <td style="width:100px">{{$injuryreport->name}}</td>
                            <td style="width:160px">{{$body_part_injureds[$injuryreport->body_part_injured-1]->name}}</td>

                            <td style="width:200px">{{$injury_types[$injuryreport->injury_type-1]->name}}</td>
                            <td style="width:100px">{{$videos[$injuryreport->video-1]->name}}</td>

                            @if($user->role==0)
                            <td style="width:100px">
                                @if($user->email==$injuryreport->email)
                                    <a href="/detail/{{$injuryreport->id}}" class="btn btn-success">{{ __('詳細') }}</a>
                                @endif
                            </td>
                            @else
                            <td style="width:100px">
                                <a href="/detail/{{$injuryreport->id}}" class="btn btn-success">{{ __('詳細') }}</a>
                            </td>
                            @endif

                            @if($user->role>1)
                            <td style="width:100px">
                                <a href="/delete/{{$injuryreport->id}}" class="btn btn-error">{{ __('削除') }}</a>
                            </td>
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-10">
                    @csrf
                    @if(false)
                    {{$injuryreports->links() }}<!-- 条件検索時にページネーションが効かない -->
                    @endif
                    {{ $injuryreports->appends(request()->query())->links() }}<!-- 条件検索時は検索条件をパラメータに渡す -->
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="/" class="btn btn-success">{{ __('戻る') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
