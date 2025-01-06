@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    <div class="row">
        {{$id}}を削除しました。（仮）
    </div>
    @endauth
</div>
<script>
@endsection
