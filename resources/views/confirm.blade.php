@extends('layouts.app')

@section('content')
<div class="container">
    < class="row">
    <h1>傷害情報の登録前確認</h1>
    <form id="example-form" action="save" method="POST" style="">
    @csrf
    <table style="border:1;">
        <thead>
            <tr>
                <th>項目</th>
                <th>値</th>
            </tr>
        </thead>
        <tbody>
            {{-- $injuryreportの属性をループして表示 --}}
            @foreach ($injuryreport->getAttributes() as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
                <div class="col-3">
                    <button type="submit" class="btn btn-primary" >{{ __('登録') }}</button>
                    <a href="/report/edit" class="btn btn-success">{{ __('編集') }}</a>
                    <a href="/" class="btn btn-success">{{ __('戻る') }}</a>
                </div>
            </div>
    </form>
    </div>
</div>
@endsection
