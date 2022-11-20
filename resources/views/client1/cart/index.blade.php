@extends('client.master' , ['specialOffer' => false])

@section('content')
    <div class="banner-bootom-w3-agileits">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">Cart Page
                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <!-- //tittle heading -->
            <div class="col-md-5 single-right-left ">
                <div class="cost">
                    <h2>پیش فاکتور</h2>

                    <table class="pricing">
                        <tbody>
                        <tr>
                            <td>قیمت کل</td>
                            <td class="subtotal">{{$cart->sum('price') * $cart->sum('quantity')}} تومان</td>
                        </tr>
                        <tr>
                            <td>مالیات</td>
                            <td class="tax">0 تومان</td>
                        </tr>
                        <tr>
                            <td>هزینه ارسال</td>
                            <td class="shipping">10000 تومان</td>
                        </tr>
                        <tr>
                            <td><strong>مجموع:</strong></td>
                            <td class="orderTotal   ">{{$cart->sum('price') * $cart->sum('quantity')}} تومان</td>
                        </tr>
                        </tbody>
                    </table>
                    <form action="{{route('cart.payment')}}" method="post">
                        <select name="type" id="type">
                            @foreach(paymentType() as $key => $item)
                                <option value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>
                        @csrf
                        <button class="btn btn-sb btn-info">پرداخت</button>
                    </form>
                </div>

            </div>
            <div class="col-md-7 single-right-left simpleCart_shelfItem">

                <table class="table table-bordered">
                    <thead>
                    <!-- start table head -->
                    <tr class="d-sm-table-row">
                        <th class="table-header">نام محصول</th>
                        <th class="table-header">قیمت</th>
                        <th class="table-header">تعداد</th>
                        <th class="table-header">مجموع</th>
                    </tr>
                    <!-- end table head -->
                    </thead>
                    <tbody>
                    <!-- start table body -->
                    @foreach($cart as $item)
                        <tr class="table-item">
                            <!-- start item one -->
                            <td>
                                <div class="item">
                                    <div class="item-front">
                                        <img src="pics/m.jpg">
                                    </div>
                                    <div class="item-back">
                                        <img src="pics/mm.jpg">
                                    </div>
                                </div>

                                <p>{{$item['product']->name}}</p>
                                <p class="description">{{$item['product']->description}}</p>
                                <p>{{$item['product']->attribute ." : " .$item['product']->value}}</p>
                            </td>
                            <td>{{$item['price']}} تومان</td>
                            <td>
                                {{$item['quantity']}}
                                @include('client.cart.addToCart',['data' => $item])
                                {{--                                <label for="quantity"></label>--}}
                                <form action="{{route('cart.item.destroy',$item['id'])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                            <td class="itemTotal">{{$item['price'] * $item['quantity']}} تومان</td>
                            <!-- end item one -->
                        </tr>
                    @endforeach
                    <!-- end table body -->
                    </tbody>
                </table>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    @slot('breadcrumbs')
        <div class="services-breadcrumb">
            <div class="agile_inner_breadcrumb">
                <div class="container">
                    <ul class="w3_short">
                        <li>
                            <a href="index.html">Home</a>
                            <i>|</i>
                        </li>
                        <li>Cart Page</li>
                    </ul>
                </div>
            </div>
        </div>
    @endslot
@endsection
