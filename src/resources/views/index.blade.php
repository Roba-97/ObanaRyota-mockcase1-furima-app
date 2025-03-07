@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="tab">
	<form class="tab__form" action="/" method="get">
		<button class="tab__btn" type="submit">おすすめ</button>
	</form>
	<form class="tab__form" action="/?tab=mylist" method="get">
		<button class="tab__btn" type="submit">マイリスト</button>
	</form>
</div>
<div class="item-list">
	@for($i = 0; $i < 8; $i++) 
	<div class="item-list__item">
		<img src="https://placehold.jp/d9d9d9/000/190x190.png?text=%E5%95%86%E5%93%81%E7%94%BB%E5%83%8F" alt="商品画像" class="item-list__img">
		<p class="item-list__name">商品名</p>
	</div>
	@endfor
</div>
@endsection