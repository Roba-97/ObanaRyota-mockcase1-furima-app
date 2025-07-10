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
                <img class="main__heading-img" src="{{ asset('images/default_user_icon.png') }}" alt="{{ $chatRoom->purchase->item->seller->name }}のアイコン画像">
                <h2 class="main__heading-text">{{ $chatRoom->purchase->item->seller->name }}さんとの取引画面</h2>
            </div>
            <button class="main__heading-button" onclick="">取引を完了する</button>
        </div>
        <div class="main__item">
            <img class="main__item-img" src="{{ asset($chatRoom->purchase->item->image_path) }}" alt="{{ $chatRoom->purchase->item->name }}の商品画像">
            <div class="main__item-inner">
                <h3 class="main__item-name">{{ $chatRoom->purchase->item->name }}</h3>
                <p class="main__item-price">￥{{ number_format($chatRoom->purchase->item->price) }}</p>
            </div>
        </div>
        <div class="main__talk">
            @foreach($messages as $message)
            @if($message->sender_id === Auth::user()->id)
            <div class="talk__item talk__item--sended">
                <div>
                    <span class="item__user-name">{{ Auth::user()->name }}</span>
                    <img class="item__user-img item__user-img--sended" src="{{ asset('images/default_user_icon.png') }}" alt="">
                </div>
                <p class="item__content-message">{!! nl2br(e($message->content)) !!}</p>
                <div class="item__content-control">
                    <button>編集</button>
                    <button>削除</button>
                </div>
            </div>
            @else
            <div class="talk__item">
                <div>
                    <img class="item__user-img" src="{{ asset('images/default_user_icon.png') }}" alt="">
                    <span class="item__user-name">{{ $chatRoom->purchase->item->seller->name }}</span>
                </div>
                <p class="item__content-message">{!! nl2br(e($message->content)) !!}</p>
            </div>
            @endif
            @endforeach
        </div>
        @if($errors)
        <p class="error">
            @foreach ($errors->all() as $error)
            {{$error}},　
            @endforeach
        </p>
        @endif
        <form class="main__submit-form" action="/chat/{{ $chatRoom->id }}" method="post">
            @csrf
            <input class="submit-form__input" type="text" name="content" placeholder="取引メッセージを記入してください">
            <label class="submit-form__label" for="send-img">画像を選択する</label>
            <input class="submit-form__input-file" type="file" id="send-img" name="image" accept="image/jpg, image/png">
            <input class="submit-form__img" type="image" src="{{ asset('images/send_button.jpg') }}" alt="">
        </form>
    </div>
</div>
@endsection