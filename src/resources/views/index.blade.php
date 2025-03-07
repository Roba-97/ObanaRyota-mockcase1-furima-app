@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="tab">
	@if($showMylist)
	<a class="tab__link" href="/">おすすめ</a>
	<a class="tab__link tab__link--active" href="/?tab=mylist" >マイリスト</a>
	@else
	<a class="tab__link tab__link--active" href="/">おすすめ</a>
	<a class="tab__link" href="/?tab=mylist" >マイリスト</a>
	@endif
</div>
<div class="item-list">
	@foreach($items as $item)
	<div class="item-list__item">
		@if($item->sold_flag)
		<a href="/item/{{ $item->id }}">
			<div class="item-list__sold-mask">
				<div class="item-list__sold-text"><span>sold</span></div>
			</div>
			<img class="item-list__img" src="{{ $item->image_path }}" alt="商品画像">
		</a>
		@else
		<a href="/item/{{ $item->id }}">
			<img class="item-list__img" src="{{ $item->image_path }}" alt="商品画像">
		</a>
		@endif
		<p class="item-list__name">{{ $item->name }}</p>
	</div>
	@endforeach
</div>
@endsection