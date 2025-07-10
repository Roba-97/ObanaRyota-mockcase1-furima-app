@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css')}}">
@endsection

@section('content')
<div class="chat">
    <div class="sidebar">
        <h2 class="sidebar__heading">その他の取引</h2>
        <ul class="sidebar__heading-list">
            @for ($i = 0; $i < 3; $i++)
                <li class="sidebar__heading-item"><a href="">商品名</a></li>
            @endfor
        </ul>
    </div>
    <div class="main">
        <div class="main__heading">
            <div class="main__heading-inner">
                <img class="main__heading-img" src="{{ asset('images/default_user_icon.png') }}" alt="">
                <h2 class="main__heading-text">「ユーザー名」さんとの取引画面</h2>
            </div>
            <form action="">
                <button class="main__heading-button">取引を完了する</button>
            </form>
        </div>
        <div class="main__item">
            <img class="main__item-img" src="{{ asset('images/default_user_icon.png') }}" alt="">
            <div class="main__item-inner">
                <h3 class="main__item-name">商品名</h3>
                <p class="main__item-price">商品価格</p>
            </div>
        </div>
        <div class="main__talk">
            @for ($i = 0; $i < 2; $i++)
            <div class="talk__item">
                <div>
                    <img class="item__user-img" src="{{ asset('images/default_user_icon.png') }}" alt="">
                    <span class="item__user-name">ユーザー名</span>
                </div>
                <p class="item__content-message">メッセージメッセージメッセージメッセージメッセージ</p>
            </div>
            <div class="talk__item talk__item--sended">
                <div>
                    <span class="item__user-name">ユーザー名</span>
                    <img class="item__user-img item__user-img--sended" src="{{ asset('images/default_user_icon.png') }}" alt="">
                </div>
                <p class="item__content-message">メッセージメッセージメッセージメッセージメッセージ</p>
            </div>
            @endfor
        </div>
        <form class="main__submit-form" action="">
            <input class="submit-form__input" type="text" name="content" placeholder="取引メッセージを記入してください">
            <label class="submit-form__label" for="send-img">画像を選択する</label>
            <input class="submit-form__input-file" type="file" id="send-img" name="image" accept="image/jpg, image/png">
            <img class="submit-form__img" src="{{ asset('images/send_button.jpg') }}" alt="">
        </form>
    </div>
</div>
@endsection