<div style="position: relative;">
    @if ($image)
    <div class="submit-form__preview">
        <img class="submit-form__preview-img" src="{{ $image->temporaryUrl() }}" alt="">
        <button class="submit-form__preview-button">画像を送信する</button>
    </div>
    @endif
    <label class="submit-form__label" for="send-img">画像を選択する</label>
    <input class="submit-form__input-file" type="file" id="send-img" name="image" wire:model="image" accept="image/jpg, image/png">
</div>