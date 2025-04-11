@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('livewireStyles')
@livewireStyles
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
				<livewire:profile-image-preview-component />
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="name">ユーザー名</label>
				<input class="profile-form__input" type="text" name="name" id="name" value="{{ old('name', $profile['name']) }}">
				<p class="profile-form__error-message">
					@error('name')
					{{ $message }}
					@enderror
				</p>
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="postcode">郵便番号</label>
				<input class="profile-form__input" type="text" name="postcode" id="postcode" value="{{ old('postcode', $profile['postcode']) }}">
				<p class="profile-form__error-message">
					@error('postcode')
					{{ $message }}
					@enderror
				</p>
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="address">住所</label>
				<input class="profile-form__input" type="text" name="address" id="address" value="{{ old('address', $profile['address']) }}">
				<p class="profile-form__error-message">
					@error('address')
					{{ $message }}
					@enderror
				</p>
			</div>
			<div class="profile-form__group">
				<label class="profile-form__label" for="building">建物名</label>
				<input class="profile-form__input" type="text" name="building" id="building" value="{{ old('building', $profile['building']) }}">
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

@section('livewireScripts')
@livewireScripts
@endsection