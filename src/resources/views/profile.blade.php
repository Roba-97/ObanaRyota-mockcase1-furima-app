@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="profile">
  <h2 class="profile__heading">プロフィール設定</h2>
  <div class="profile-form__inner">
    <form class="profile-form__form" action="/mypage/profile" method="post">
      @method('DELETE')
      @csrf
			<div class="profile-form__group-img">
				<img class="profile-form__img" src="https://placehold.jp/150x150.png" alt="">
				<label class="profile-form__label-img" for="image_input">画像を選択する</label>
				<input class="profile-form__input-img" type="file" id="image_input">
			</div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="name">ユーザー名</label>
        <input class="profile-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
        <p class="profile-form__error-message">
          @error('name')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="postcode">郵便番号</label>
        <input class="profile-form__input" type="text" name="postcode" id="postcode" value="">
        <p class="profile-form__error-message">
          @error('postcode')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="address">住所</label>
        <input class="profile-form__input" type="text" name="address" id="address" value="">
        <p class="profile-form__error-message">
          @error('address')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="building">建物名</label>
        <input class="profile-form__input" type="text" name="building" id="building" value="">
        <p class="profile-form__error-message">
          @error('building')
          {{ $message }}
          @enderror
        </p>
      </div>
      <button class="profile-form__btn" type="submit">更新する</button>
    </form>
  </div>
</div>
@endsection