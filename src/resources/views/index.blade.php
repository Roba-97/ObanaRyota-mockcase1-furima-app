@extends('layouts.app')

@section('content')
<form action="/logout" method="post">
@csrf
<button type="submit">ログアウト</button>
</form>
@endsection