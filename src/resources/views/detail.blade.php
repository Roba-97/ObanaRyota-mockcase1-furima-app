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
            <p class="item-detail__brand">ブランド名</p>
            <p class="item-detail__price">￥<span>{{ number_format($item->price) }}</span>(税込)</p>
        </div>
        <div class="item-detail__icon">
            <div class="item-detail__icon-like">
                <img class="icon__img" src="{{ asset('images/star.png') }}" alt="">
                <div class="icon__count">3</div>
            </div>
            <div class="item-detail__icon-comment">
                <img class="icon__img" src="{{ asset('images/comment.png') }}" alt="">
                <div class="icon__count">1</div>
            </div>
        </div>
        <form class="item-detail__purchase" action="/purcahse/{{ $item->id }}" method="get">
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
                    <span>洋服</span><span>メンズ</span><span>ファッション</span>
                </div>
            </div>
            <div class="item-detail__info-condition">
                <div class="info-condition__heading"><p>商品の状態</p></div>
                <div class="info-condition__text"><span>良好</span></div>
            </div>
        </div>
        <div class="item-detail__comment">
            <h2 class="item-detail__comment-heading">コメント(1)</h2>
            <div class="item-detail__comment-content">
                <img src="https://placehold.jp/150x150.png" alt="ユーザアイコン" class="comment__user-img">
                <span class="comment__user-name">admin</span>
                <div class="comment__text"><p>ユーザのコメント</p></div>
            </div>
            <form class="item-detail__comment-form" action="" method="post">
                @csrf
                <label class="comment-form_label" for="input-comment">商品へのコメント</label>
                <textarea class="comment-form__input" name="content" id="input-comment" rows="10"></textarea>
                <button class="comment-form__btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection