@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    <h3>プロフィール情報：{{$user->name}}</h3>
    <div class="row">
        <div class="col-3"><label class="form-label">ユーザーID</label></div>
        <div class="col-8">{{$user->id}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">ユーザー名</label></div>
        <div class="col-8">{{$user->name}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">ふりがな</label></div>
        <div class="col-8">{{$user->furigana}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">性別</label></div>
        <div class="col-8">{{$user->gender}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">役職</label></div>
        <div class="col-8">{{$user->part}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">メール</label></div>
        <div class="col-8">{{$user->email}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">ユーザーID</label></div>
        <div class="col-8">{{$user->jiss_share_id}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">権限</label></div>
        <div class="col-8">{{$user->role}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">JISS shareグループ</label></div>
        <div class="col-8">{{$user->jiss_share_group}}</label></div>
    </div>
    <div class="row">
        <div class="col-3"><label class="form-label">所属グループ</label></div>
        <div class="col-8">{{$user->affiliation}}</label></div>
    </div>
    @endauth
</div>
<script>
@endsection
