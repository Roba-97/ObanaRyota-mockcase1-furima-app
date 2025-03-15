@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<div class="item-detail">
    <div class="item-detail__item-img">
        <img src="{{ $item->image_path }}" alt="商品画像">
    </div>
    <div class="item-detail__detail">
        <div class="item-detail__top">
            <h2 class="item-detail__name">{{ $item->name }}</h2>
            <p class="item-detail__brand">{{ $item->brand }}</p>
            <p class="item-detail__price">￥<span>{{ number_format($item->price) }}</span>(税込)</p>
        </div>
        <div class="item-detail__icon">
            <div class="item-detail__icon-like">
                <img class="icon__img" src="{{ asset('images/star.png') }}" alt="">
                <div class="icon__count">{{ $item->favorites()->count() }}</div>
            </div>
            <div class="item-detail__icon-comment">
                <img class="icon__img" src="{{ asset('images/comment.png') }}" alt="">
                <div class="icon__count">{{ $comments->count() }}</div>
            </div>
        </div>
        <form class="item-detail__purchase" action="/purchase/{{ $item->id }}" method="get">
            <button class="item-detail__purchase-btn" type="submit">購入手続きへ</button>
        </form>
        <div class="item-detail__desc">
            <h2 class="item-detail__desc-heading">商品説明</h2>
            <p class="item-detail__desc-text">{{ $item->detail }}</p>
        </div>
        <div class="item-detail__info">
            <h2 class="item-detail__info-heading">商品情報</h2>
            <div class="item-datail__info-category">
                <div class="info-category__heading"><p>カテゴリー</p></div>
                <div class="info-category__list">
                    @foreach($categories as $category)
                    <span>{{ $category->content }}</span>
                    @endforeach
                </div>
            </div>
            <div class="item-detail__info-condition">
                <div class="info-condition__heading"><p>商品の状態</p></div>
                <div class="info-condition__text"><span>{{ $condition->content }}</span></div>
            </div>
        </div>
        <div class="item-detail__comment">
            <h2 class="item-detail__comment-heading">コメント({{ $comments->count() }})</h2>
            <div class="item-detail__comment-content">
            @foreach($comments as $comment)
                @isset($comment->user()->first()->profile()->first()->image_path)
                <img src="{{ $comment->user()->first()->profile()->first()->image_path }}" alt="ユーザアイコン" class="comment__user-img">
                @else
                <img src="{{ asset('images/default_user_icon.png') }}" alt="ユーザアイコン" class="comment__user-img">
                @endisset
                <span class="comment__user-name">{{ $comment->user()->first()->name }}</span>
                <div class="comment__text"><p>{{ $comment->content }}</p></div>
            @endforeach
            </div>
            <form class="item-detail__comment-form" action="/comment/{{ $item->id }}" method="post">
                @csrf
                <label class="comment-form_label" for="input-comment">商品へのコメント</label>
                <textarea class="comment-form__input" name="content" id="input-comment" rows="10"></textarea>
                <button class="comment-form__btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection