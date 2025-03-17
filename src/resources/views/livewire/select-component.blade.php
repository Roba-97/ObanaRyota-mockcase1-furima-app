<div>
    <label class="purchase-info__method-label">支払い方法</label>
    <select class="purchase-info__select" wire:model="selectedValue" wire:change="$emit('valueUpdated', $event.target.value)">
        <option class="purchase-info__select-item" value="" selected disabled hidden>選択してください</option>
        <option class="purchase-info__select-item" value="1">コンビニ払い</option>
        <option class="purchase-info__select-item" value="2">カード払い</option>
    </select>
</div>
