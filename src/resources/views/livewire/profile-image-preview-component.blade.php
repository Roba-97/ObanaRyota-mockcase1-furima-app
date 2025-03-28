<div>
    @if ($image)
    <img class="profile-form__img" src="{{ $image->temporaryUrl() }}" alt="更新ユーザアイコン">
    @elseif(Auth::user()->profile()->first()->image_path)
    <img class="profile-form__img" src="{{ asset(Auth::user()->profile()->first()->image_path) }}" alt="ユーザアイコン">
    @else
    <img class="profile-form__img" src="{{ asset('images/default_user_icon.png') }}" alt="ユーザアイコン">
    @endif
    <label class="profile-form__label-img" for="image_input">画像を選択する</label>
    <input class="profile-form__input-img" type="file" id="image_input" name="image" wire:model="image" accept="image/jpg, image/png">
    <p class=" profile-form__error-message">
        @error('image')
        {{ $message }}
        @enderror
    </p>
</div>