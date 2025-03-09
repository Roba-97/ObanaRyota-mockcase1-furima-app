@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<h2>マイページ</h2>
@endsection