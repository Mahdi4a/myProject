{{--@if(count($orders))--}}
<div class="d-flex justify-content-between mb-2" style="font-size: 16px">
    <span class="align-self-start">وضعیت سفارش :
        @if(($order->status) === 'paid')
            <span class="btn btn-success mx-1">{{$order->status}}</span>
        @else
            <span class="btn btn-warning mx-1">{{$order->status}}</span>
        @endif
    </span>
</div>
<div class="d-flex justify-content-end mb-3 flex-wrap p-3 " style="border:1px solid silver">
    <div class="col-sm-4 mb-2">نام مشتری: {{$order->user->name}}</div>
    <div class="col-sm-4 mb-2">شماره همراه: {{$order->user->phone_number}}</div>
    <div class="col-sm-4 mb-2">تاریخ: {{jdate($order->created_at)}}</div>
</div>
<div class="d-flex text-right mb-3 flex-wrap p-3 " style="border:1px solid silver">
    توضیحات: {{$order->description}}
</div>
<div class="mb-3 text-center" style="border:1px solid silver">
    <h5 class="p-3 text-center">ایتم های سفارش</h5>
    <div class="">
        <table class="table mobile-accordion table-striped w-100 table-responsive-sm mb-0"
               style="font-size: 13px !important">
            <thead class="thead" style="background: #d8d8d8">
            <tr class="tr">
                <th class="th">کد محصول</th>
                <th class="th">نام محصول</th>
                <th class="th">ویژگی محصول</th>
                <th class="th">مقدار ویژگی محصول</th>
                <th class="th">تعداد</th>
                <th class="th">قیمت</th>
                <th class="th">جمع مبلغ کل</th>

            </tr>
            </thead>
            <tbody class="tbody">
            @foreach($order->orderItems as $item)
                <tr class="tr alternate-highlight">
                    <td class=" td" data-header="کد محصول:">{{$item->id}}</td>
                    <td class=" td" data-header="نام محصول:">{{$item->name}}</td>
                    <td class=" td" data-header="نام محصول:">{{$item->pivot->attribute->name}}</td>
                    <td class=" td" data-header="نام محصول:">{{$item->pivot->value->value}}</td>
                    <td class=" td" data-header="نام محصول:">{{$item->pivot->quantity}}</td>
                    <td class=" td" data-header="قیمت:">{{number_format($item->pivot->price ?? 0)}}</td>
                    <td class=" td"
                        data-header="قیمت:">{{number_format($item->pivot->price * $item->pivot->quantity)}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div>

</div>
<hr>
