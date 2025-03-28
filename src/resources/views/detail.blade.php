@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('livewireStyles')
@livewireStyles
@endsection

@section('content')

<div class="item-detail">
    <livewire:popup-component :item="$item" />
    <div class="item-detail__detail">
        <div class="item-detail__top">
            <h2 class="item-detail__name">{{ $item->name }}</h2>
            <p class="item-detail__brand">{{ $item->brand }}</p>
            <p class="item-detail__price">￥<span>{{ number_format($item->price) }}</span>(税込)</p>
        </div>
        <div class="item-detail__icon">
            <div class="item-detail__icon-like">
                @if(Auth::check() && Auth::user()->favorites()->where('item_id', $item->id)->exists())
                <a href="/favorite/{{ $item->id }}">
                    <img class="icon__img" src="{{ asset('images/filled_star.png') }}" alt="">
                </a>
                @else
                <a href="/favorite/{{ $item->id }}">
                    <img class="icon__img" src="{{ asset('images/star.png') }}" alt="">
                </a>
                @endif
                <div class="icon__count">{{ $item->favorites()->count() }}</div>
            </div>
            <div class="item-detail__icon-comment">
                <a href="#comment-heading">
                    <img class="icon__img" src="{{ asset('images/comment.png') }}" alt="">
                </a>
                <div class="icon__count">{{ $comments->count() }}</div>
            </div>
        </div>
        @if($item->sold_flag)
        <div class="item-detail__purchase" action="/purchase/{{ $item->id }}" method="get">
            <span class="item-detail__purchase-btn item-detail__purchase-btn--sold">この商品は購入されています</span>
        </div>
        @else
        <form class="item-detail__purchase" action="/purchase/{{ $item->id }}" method="get">
            <button class="item-detail__purchase-btn" type="submit">購入手続きへ</button>
        </form>
        @endif
        <div class="item-detail__desc">
            <h2 class="item-detail__desc-heading">商品説明</h2>
            <p class="item-detail__desc-text">{!! nl2br(e($item->detail)) !!}</p>
        </div>
        <div class="item-detail__info">
            <h2 class="item-detail__info-heading">商品情報</h2>
            <div class="item-datail__info-category">
                <div class="info-category__heading">
                    <p>カテゴリー</p>
                </div>
                <div class="info-category__list">
                    @foreach($categories as $category)
                    <span>{{ $category->content }}</span>
                    @endforeach
                </div>
            </div>
            <div class="item-detail__info-condition">
                <div class="info-condition__heading">
                    <p>商品の状態</p>
                </div>
                <div class="info-condition__text"><span>{{ $condition->content }}</span></div>
            </div>
        </div>
        <div class="item-detail__comment">
            <h2 id="comment-heading" class="item-detail__comment-heading">コメント({{ $comments->count() }})</h2>
            <div class="item-detail__comment-content">
                @foreach($comments as $comment)
                @isset($comment->user()->first()->profile()->first()->image_path)
                <img src="{{ asset($comment->user()->first()->profile()->first()->image_path) }}" alt="ユーザアイコン" class="comment__user-img">
                @else
                <img src="{{ asset('images/default_user_icon.png') }}" alt="ユーザアイコン" class="comment__user-img">
                @endisset
                <span class="comment__user-name">{{ $comment->user()->first()->name }}</span>
                <div class="comment__text">
                    <p>{!! nl2br(e($comment->content)) !!}</p>
                </div>
                @endforeach
            </div>
            <form id="comment-form" class="item-detail__comment-form" action="/comment/{{ $item->id }}" method="post">
                @csrf
                <label class="comment-form_label" for="input-comment">商品へのコメント</label>
                <textarea class="comment-form__input" name="content" id="input-comment" rows="10">{{ old('content') }}</textarea>
                <p class="comment-form__error-message">
                    @error('content')
                    {{ $message }}
                    @enderror
                </p>
                <button class="comment-form__btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('livewireScripts')
@livewireScripts
@endsection