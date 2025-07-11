@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css')}}">
<link rel="stylesheet" href="{{ asset('css/chat_modal.css')}}">
@endsection

@section('content')
<div class="chat">
    <div class="sidebar">
        <h2 class="sidebar__heading">その他の取引</h2>
        <ul class="sidebar__heading-list">
            @foreach($dealingItems as $item)
            @if($item->purchase->chatRoom->id === $chatRoom->id)
            @continue
            @endif
            <a href="/chat/{{ $item->purchase->chatRoom->id }}">
                <li class="sidebar__heading-item">{{ $item->name }}</li>
            </a>
            @endforeach
        </ul>
    </div>

    <div class="main">
        <div class="main__heading">
            <div class="main__heading-inner">
                <img class="main__heading-img" src="{{ asset('images/default_user_icon.png') }}" alt="{{ $chatRoom->purchase->item->seller->name }}のアイコン画像">
                <h2 class="main__heading-text">{{ $chatRoom->getOtherParticipant(Auth::user())->name }}さんとの取引画面</h2>
            </div>
            @if($chatRoom->isBuyer(Auth::user()))
            <button id="js-deal-modal-open-button" class="main__heading-button">取引を完了する</button>
            @endif
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
                    <button onclick="openMessageControlModal('edit', {{ $message->toJson(JSON_UNESCAPED_UNICODE) }} )">編集</button>
                    <button onclick="openMessageControlModal('delete', {{ $message->toJson(JSON_UNESCAPED_UNICODE) }} )">削除</button>
                </div>
            </div>
            @else
            <div class="talk__item">
                <div>
                    <img class="item__user-img" src="{{ asset('images/default_user_icon.png') }}" alt="">
                    <span class="item__user-name">{{ $chatRoom->getOtherParticipant(Auth::user())->name }}</span>
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
            <input class="submit-form__input" name="content" placeholder="取引メッセージを記入してください">
            <label class="submit-form__label" for="send-img">画像を選択する</label>
            <input class="submit-form__input-file" type="file" id="send-img" name="image" accept="image/jpg, image/png">
            <input class="submit-form__img" type="image" src="{{ asset('images/send_button.jpg') }}" alt="">
        </form>

        <div id="js-chat-deal-modal" class="chat-modal">
            <div class="chat-modal__inner">
                <div class="inner__header">
                    <p class="inner__header-text">取引が完了しました。</p>
                </div>
                <form class="inner__deal-form" action="/chat/{{ $chatRoom->id }}/deal" method="post">
                    @csrf
                    <div class="deal-form__evaluation">
                        <p class="deal-form__evaluation-text">今回の取引相手はどうでしたか？</p>
                        <div class="deal-form__evaluation-star">
                            <input id="star5" type="radio" name="rate" value="5"><label for="star5">★</label>
                            <input id="star4" type="radio" name="rate" value="4"><label for="star4">★</label>
                            <input id="star3" type="radio" name="rate" value="3"><label for="star3">★</label>
                            <input id="star2" type="radio" name="rate" value="2"><label for="star2">★</label>
                            <input id="star1" type="radio" name="rate" value="1"><label for="star1">★</label>
                        </div>
                    </div>
                    <button class="deal-form__button">送信する</button>
                </form>
            </div>
        </div>

        <div id="js-message-control-modal" class="chat-modal message-control">
            <div class="message-control__inner">
                <div class="inner__header inner__header--flex">
                    <p id="js-message-control-heading" class="inner__header-text"></p>
                    <button id="js-close-modal-button" class="inner__close-button" onclick="closeModal()">×</button>
                </div>
                <form id="js-message-control-form" class="message-control__form" method="post">
                    @csrf
                    <input id="js-message-id-input" type="hidden" name="message-id">
                    <textarea id="js-message-textarea" class="message-control__form-textarea" name="content"></textarea>
                    <button id="js-message-control-submit-button" class="message-control__form-button"></button>
                </form>
            </div>
        </div>

    </div>
</div>
<script src="{{ asset('js/modal.js') }}"></script>
@endsection