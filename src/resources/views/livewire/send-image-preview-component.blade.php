<div style="position: relative;">
    @if ($image)
    <img class="submit-form__img-preview" src="{{ $image->temporaryUrl() }}" alt="">
    @endif
    <label class="submit-form__label" for="send-img">画像を選択する</label>
    <input class="submit-form__input-file" type="file" id="send-img" name="image" wire:model="image" accept="image/jpg, image/png">
</div>