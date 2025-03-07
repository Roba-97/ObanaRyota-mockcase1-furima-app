@extends('layouts.app')

@section('content')
<h2>プロフィール編集ページ</h2>
<form action="/logout" method="post">
@csrf
<button type="submit">ログアウト</button>
</form>
@endsection