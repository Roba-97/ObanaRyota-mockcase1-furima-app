<td class="purchase-summary__table-text">
    @if ($selectedValue == '1')
        コンビニ払い
        <input type="hidden" name="payment" value="1">
    @elseif ($selectedValue == '2')
        カード払い
        <input type="hidden" name="payment" value="2">
    @endif
</td>