@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('livewireStyles')
@livewireStyles
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
            <livewire:select-component />
            <p class="purchase-info__select-error">
                @error('payment')
                {{ $message }}
                @enderror
            </p>
        </div>
        <div class="purchase-info__address">
            <div class="purchase-info__address-top">
                <label class="purchase-info__address-label" for="">配送先</label>
                <a class="purchase-info__address-link" href="/purchase/address/{{ $item->id }}">変更する</a>
            </div>
            <p class="purchase-info__address-text" >
                〒 {{ $delivery_address->postcode }}<br>{{ $delivery_address->address . $delivery_address->building}}
            </p>
            <p class="purchase-info__address-error">
                @error('delivery_address')
                {{ $message }}
                @enderror
            </p>
        </div>
    </div>
    <div class="purchase-summary">
        <form class="purchase-summary__inner" action="/purchase/{{ $item->id }}" method="post">
        @csrf
            <table class="purchase-summary__table">
                <tr class="purchase-summary__table-row">
                    <th class="purchase-summary__table-heading">商品代金</th>
                    <td class="purchase-summary__table-text">￥<span>{{ number_format($item->price) }}</span></td>
                </tr>
                <tr class="purchase-summary__table-row">
                    <th class="purchase-summary__table-heading">支払い方法</th>
                    <livewire:display-component />
                </tr>
            </table>
            <input type="hidden" name="delivery_address" value="{{ $delivery_address->address . $delivery_address->building}}">
            <button class="purchase-summary__form-btn" type="submit">購入する</button>
        </form>
    </div>    
</div>
@endsection

@section('livewireScripts')
@livewireScripts
@endsection