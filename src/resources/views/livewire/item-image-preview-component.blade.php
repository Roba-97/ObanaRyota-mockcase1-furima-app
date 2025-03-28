<div>
    <div class="sell-form__group-img">
        @if ($image)
        <img class="sell-form__img" src="{{ $image->temporaryUrl() }}" alt="出品商品の画像">
        @endif
        <label class="sell-form__label-img" for="image_input">画像を選択する</label>
        <input class="sell-form__input-img" type="file" id="image_input" name="image" wire:model="image" accept="image/jpg, image/png">
    </div>
</div>