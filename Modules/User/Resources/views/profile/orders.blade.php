@extends('user::profile.layout')
@section('profile','')
@section('twoFactor','')
@section('orders','active')
@section('main')
    <h4>orders</h4>
    <hr>
    <table class="table table-hover">
        <tbody>
        <tr>
            <th>شماره سفارش</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت سفارش</th>
            <th>کد رهگیری پستی</th>
            <th>اقدامات</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{jdate($order->created_at)->format('%d %B %Y')}}</td>
                <td>{{$order->status}}</td>
                <td>{{$order->tracking_serial}}</td>
                <td>
                    <button class="btn btn-sm btn-info order-detail" data-item="{{$order->id}}" data-toggle="modal"
                            data-target="#baseModal">جزئیات
                    </button>
                    @if($order->status === 'unpaid')
                        <a href="{{route('order.payment',$order->id)}}" class="btn btn-sm btn-warning">پرداخت</a>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$orders->render()}}

@endsection
