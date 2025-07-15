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
	<div class="user__inner">
		<p class="user__name">{{ Auth::user()->name }}</p>
		@if(Auth::user()->profile->rating_count !== 0)
		<p class="user__evaluation">
			@for($i = 0; $i < 5; $i++)
			@if($i < round(Auth::user()->profile->rating_average))
			<span class="user__evaluation--filled-star">★</span>
			@else
			<span>★</span>
			@endif
			@endfor
		</p>
		@endif
	</div>
	<form class="user__edit-form" action="/mypage/profile" method="get">
		<button class="user__edit-btn" type="submit">プロフィールを編集</button>
	</form>
</div>
<div class="tab">
	<a href="/mypage/?page=sell" @class(['tab__link', 'tab__link--active'=> $param === null])>出品した商品</a>
	<a href="/mypage/?page=buy" @class(['tab__link', 'tab__link--active'=> $param === 'buy'])>購入した商品</a>
	<a href="/mypage/?page=deal" @class(['tab__link', 'tab__link--active'=> $param === 'deal'])>
		取引中の商品
		@if($notificationCount !== 0)
		<span>
			{{ $notificationCount }}
		</span>
		@endif
	</a>
</div>
<div class="item-list">
	@foreach($items as $item)
	<div class="item-list__item">
		@if($param === null && $item->sold_flag)
		<a href="/item/{{ $item->id }}">
			<div class="item-list__sold-mask">
				<div class="item-list__sold-text"><span>sold</span></div>
			</div>
			<img class="item-list__img" src="{{ asset( $item->image_path ) }}" alt="商品画像">
		</a>
		@elseif($param === 'deal')
		<a href="/chat/{{ $item->chatRoom->id }}">
			<img class="item-list__img" src="{{ asset( $item->image_path ) }}" alt="商品画像">
			@if($item->chatRoom->getNotificationCount(Auth::user()) !== 0)
			<span class="item-list__chat-count">{{ $item->chatRoom->getNotificationCount(Auth::user()) }}</span>
			@endif
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