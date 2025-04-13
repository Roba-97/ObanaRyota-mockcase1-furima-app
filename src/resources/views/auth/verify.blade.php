@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify.css')}}">
@endsection

@section('content')
<div class="verify">
    <div class="verify-inner">
        <p class="verify__message">
            @if(session('message'))
            {{ session('message') }}<br>
            @else
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            @endif
            メール認証を完了してください。
        </p>
        <a class="verify__button" href="http://localhost:8025/">認証はこちらから</a>
        <form class="verify__form" action="/email/verification-notification" method="post">
            @csrf
            <button class="verify__link" type="submit">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection