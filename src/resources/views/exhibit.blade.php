@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibit.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<div class="sell-form">
  <h2 class="sell-form__heading">商品の出品</h2>
  <div class="sell-form__inner">
    <form class="sell-form__form" action="/sell" method="post">
      @csrf
			<label class="sell-form__label" for="name">商品画像</label>
      <div class="sell-form__group-img">
        <label class="sell-form__label-img" for="image_input">画像を選択する</label>
				<input class="sell-form__input-img" type="file" id="image_input">
      </div>
			<h3 class="sell-form__sub-heading">商品の詳細</h3>
			<div class="sell-form__group">
				<label class="sell-form__label sell-form__label--category">カテゴリー</label>
				@foreach($categories as $category)
				<input class="sell-form__input-check" id="{{ 'category' . $category->id }}" type="checkbox"/>
        <label class="sell-form__label-check" for="{{ 'category' . $category->id }}">{{ $category->content }}</label>
				@endforeach
			</div>
			<div class="sell-form__group">
				<label class="sell-form__label sell-form__label--condition">商品の状態</label>
				<select class="sell-form__select" name="" id="">
					<option class="sell-form__select-item" value="" selected disabled>選択してください</option>
					@foreach($conditions as $condition)
					<option class="sell-form__select-item" name="condition" value="{{ $condition->id }}">{{ $condition->content }}</option>
					@endforeach
				</select>
			</div>

			<h3 class="sell-form__sub-heading">商品名と説明</h3>
      <div class="sell-form__group">
        <label class="sell-form__label" for="name">商品名</label>
        <input class="sell-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
        <p class="sell-form__error-message">
          @error('name')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="sell-form__group">
        <label class="sell-form__label" for="brand">ブランド名</label>
        <input class="sell-form__input" type="text" name="brand" id="brand" value="{{ old('brand') }}">
      </div>
      <div class="sell-form__group">
        <label class="sell-form__label" for="detail">商品の説明</label>
        <textarea class="sell-form__input-detail" name="detail" id="detail" rows="6"></textarea>
        <p class="sell-form__error-message">
          @error('detail')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="sell-form__group">
        <label class="sell-form__label" for="price">販売価格</label>
        <input class="sell-form__input" type="text" name="price" id="price" value="">
        <p class="sell-form__error-message">
          @error('price')
          {{ $message }}
          @enderror
        </p>
      </div>
      <button class="sell-form__btn" type="submit">出品する</button>
    </form>
  </div>
</div>
@endsection