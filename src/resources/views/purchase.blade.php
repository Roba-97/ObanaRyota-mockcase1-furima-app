@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="purchase">
    <div class="purchase-info">
        <div class="purchase-info__item">
            <img src="{{ $item->image_path }}" alt="" class="purchase-info__item-img">
            <div class="purchase-info__item-text">
                <h2 class="purchase-info__item-name">{{ $item->name }}</h2>
                <p class="purchase-info__item-price">￥<span>{{ number_format($item->price) }}</span></p>
            </div>
        </div>
        <div class="purchase-info__method">
            <form action="">
                <label class="purchase-info__method-label" for="">支払い方法</label>
                <select class="purchase-info__select" name="" id="">
                    <option class="purchase-info__select-item" value="">選択してください</option>
                    <option class="purchase-info__select-item" value="">コンビニ払い</option>
                    <option class="purchase-info__select-item" value="">カード払い</option>
                </select>
            </form>
        </div>
        <div class="purchase-info__address">
            <div class="purchase-info__address-top">
                <label class="purchase-info__address-label" for="">配送先</label>
                <a class="purchase-info__address-link" href="">変更する</a>
            </div>
            <p class="purchase-info__address-text" >〒 XXX-YYYY<br>ここには配送先住所が入ります</p>
        </div>
    </div>
    <div class="purchase-summary">
        <div class="purchase-summary__inner">
            <table class="purchase-summary__table">
                <tr class="purchase-summary__table-row">
                    <th class="purchase-summary__table-heading">商品代金</th>
                    <td class="purchase-summary__table-text">￥<span>{{ number_format($item->price) }}</span></td>
                </tr>
                <tr class="purchase-summary__table-row">
                    <th class="purchase-summary__table-heading">支払い方法</th>
                    <td class="purchase-summary__table-text">コンビニ払い</td>
                </tr>
            </table>
            <form class="purchase-summary__form" action="" method="post">
                @csrf
                <button class="purchase-summary__form-btn">購入する</button>
            </form>
        </div>
    </div>    
</div>
@endsection