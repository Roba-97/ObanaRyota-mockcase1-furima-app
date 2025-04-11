@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="user">
	@isset(Auth::user()->profile()->first()->image_path)
	<img class="user__img" src="{{ asset(Auth::user()->profile()->first()->image_path) }}" alt="ユーザアイコン">
	@else
	<img class="user__img" src="{{ asset('images/default_user_icon.png') }}" alt="ユーザアイコン">
	@endisset
	<span class="user__name">{{ Auth::user()->name }}</span>
	<form class="user_edit-form" action="/mypage/profile" method="get">
		<button class="user_edit-btn" type="submit">プロフィールを編集</button>
	</form>
</div>
<div class="tab">
	@if($showSellItems)
	<a class="tab__link tab__link--active" href="/mypage/?page=sell">出品した商品</a>
	<a class="tab__link" href="/mypage/?page=buy">購入した商品</a>
	@else
	<a class="tab__link" href="/mypage/?page=sell">出品した商品</a>
	<a class="tab__link tab__link--active" href="/mypage/?page=buy">購入した商品</a>
	@endif
</div>
<div class="item-list">
	@foreach($items as $item)
	<div class="item-list__item">
		@if($showSellItems && $item->sold_flag)
		<a href="/item/{{ $item->id }}">
			<div class="item-list__sold-mask">
				<div class="item-list__sold-text"><span>sold</span></div>
			</div>
			<img class="item-list__img" src="{{ asset( $item->image_path ) }}" alt="商品画像">
		</a>
		@else
		<a href="/item/{{ $item->id }}">
			<img class="item-list__img" src="{{ asset( $item->image_path ) }}" alt="商品画像">
		</a>
		@endif
		<p class="item-list__name">{{ $item->name }}</p>
	</div>
	@endforeach
</div>
@endsection