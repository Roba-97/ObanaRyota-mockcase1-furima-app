@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="address-form">
  <h2 class="address-form__heading">住所の変更</h2>
  <div class="address-form__inner">
    <form class="address-form__form" action="/purchase/address/{{ $item->id }}" method="post">
      @csrf
      <div class="address-form__group">
        <label class="address-form__label" for="postcode">郵便番号</label>
        <input class="address-form__input" type="text" name="postcode" id="postcode" value="{{ old('postcode') }}">
        <p class="address-form__error-message">
          @error('postcode')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="address-form__group">
        <label class="address-form__label" for="address">住所</label>
        <input class="address-form__input" type="text" name="address" id="address" value="{{ old('address') }}">
        <p class="address-form__error-message">
          @error('address')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="address-form__group">
        <label class="address-form__label" for="building">建物名</label>
        <input class="address-form__input" type="text" name="building" id="building" value="{{ old('building') }}">
        <p class="address-form__error-message">
          @error('building')
          {{ $message }}
          @enderror
        </p>
      </div>
      <button class="address-form__btn" type="submit">更新する</button>
    </form>
  </div>
</div>
@endsection