@extends('layouts.app')

@section('content')
<div class="container">
    @auth
    <div class="row">
        {{$id}}を編集しました。（仮）
    </div>
    @endauth
</div>
{{-- JavaScriptでリダイレクトを設定 --}}
<script>
    // 2秒後にリダイレクト
    setTimeout(function() {
        window.location.href = '/detail/{{$id}}';
    }, 2000); // 2000ミリ秒 = 2秒
</script>

@endsection
