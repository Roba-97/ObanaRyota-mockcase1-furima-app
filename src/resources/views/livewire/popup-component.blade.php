<div>
    <div class="item-detail__item-img">
        <img wire:click="openPopup()" src="{{ asset($item->image_path) }}" alt="{{ $item->name }}の商品画像">
    </div>
    <p class="popup__hint">画像クリックで拡大</p>
    @if($showPopup)
    <div class="popup__bg"></div>
    <div class="popup">
        <img class="popup__img" src="{{ asset($item->image_path) }}" alt="{{ $item->name }}の商品画像">
        <button class="popup__close" wire:click="closePopup()">閉じる</button>
    </div>
    @endif
</div>