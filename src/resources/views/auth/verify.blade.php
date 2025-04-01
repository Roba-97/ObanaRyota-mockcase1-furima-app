@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify.css')}}">
@endsection

@section('content')
<div class="verify">
    <div class="verify-inner">
        <p class="verify__message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>
        <a href="" class="verify__button">認証はこちらから</a>
        <a href="" class="verify__link">認証メールを再送する</a>
    </div>
</div>
@endsection