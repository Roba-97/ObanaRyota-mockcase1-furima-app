@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<h2>プロフィール編集ページ</h2>
@endsection