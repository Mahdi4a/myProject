@if(($data->firstValue->inventory ?? $data['quantity']) === 0)
    <div>not available</div>
@else
    <form action="{{route('cart.add', $data->id ?? $data['subject_id'])}}" method="post" class="py-2">
        @csrf
        <fieldset>
            <input type="hidden" name="add" value="1"/>
            <input type="hidden" class="cart_value" name="value"
                   value="{{$data->firstValue->id ?? $data['attribute_value'] ?? 0}}"/>
            <input type="hidden" class="cart_attribute_id" name="attribute_id"
                   value="{{$data->firstAttribute->id ?? $data['attribute'] ?? 0}}"/>
            <input type="submit" name="submit" value="Add to cart" class="button"/>
        </fieldset>
    </form>
    @if( \Modules\Cart\Service\Cart::count((is_array($data) ? $data['product'] : $data),$data->firstAttribute->id ?? $data['attribute'],$data->firstValue->id ?? $data['attribute_value']) > 0)
        <form action="{{route('cart.add', $data->id ?? $data['subject_id'])}}" method="post">
            @csrf
            <fieldset>
                <input type="hidden" name="add" value="-1"/>
                <input type="hidden" class="cart_value" name="value"
                       value="{{$data->firstValue->id ?? $data['attribute_value'] ?? 0}}"/>
                <input type="hidden" class="cart_attribute_id" name="attribute_id"
                       value="{{$data->firstAttribute->id ?? $data['attribute'] ?? 0}}"/>
                <input type="submit" name="submit" value="reduce from cart" class="button"/>
            </fieldset>
        </form>
    @endif
@endif
