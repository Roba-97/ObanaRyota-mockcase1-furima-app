@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="profile-form">
	<h2 class="profile-form__heading">プロフィール設定</h2>
	<div class="profile-form__inner">
		<form class="profile-form__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
			@method('PATCH')
			@csrf
			<div class="profile-form__group-img">
				@isset(Auth::user()->profile()->first()->image_path)
				<img class="profile-form__img" src="{{ asset(Auth::user()->profile()->first()->image_path) }}" alt="ユーザアイコン">
				@else
				<img class="profile-form__img" src="{{ asset('images/default_user_icon.png') }}" alt="ユーザアイコン">
				@endisset
				<label class="profile-form__label-img" for="image_input">画像を選択する</label>
				<input class="profile-form__input-img" type="file" id="image_input" name="image">
				<p class="profile-form__error-message">
					@error('image')
					{{ $message }}
					@enderror
				</p>
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
				<input class="profile-form__input" type="text" name="postcode" id="postcode" value="{{ old('postcode') }}">
				<p class="profile-form__error-message">
					@error('postcode')
					{{ $message }}
					@enderror
				</p>
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="address">住所</label>
				<input class="profile-form__input" type="text" name="address" id="address" value="{{ old('address') }}">
				<p class="profile-form__error-message">
					@error('address')
					{{ $message }}
					@enderror
				</p>
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="building">建物名</label>
				<input class="profile-form__input" type="text" name="building" id="building" value="{{ old('building') }}">
				<p class="profile-form__error-message">
					@error('building')
					{{ $message }}
					@enderror
				</p>
			</div>
			@if(Auth::user()->profile()->exists())
			<button class="profile-form__btn" type="submit">更新する</button>
			@else
			<button class="profile-form__btn" type="submit">登録する</button>
			@endif
		</form>
	</div>
</div>
@endsection