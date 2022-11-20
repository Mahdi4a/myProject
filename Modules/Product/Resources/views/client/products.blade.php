@extends('main::client.master')

@section('content')
    {{--    <div class="container">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-md-12">--}}
    {{--                @foreach($products->chunk(4) as $row)--}}
    {{--                    <div class="row">--}}
    {{--                        @foreach($row as $product)--}}
    {{--                            <div class="col-3">--}}
    {{--                                <div class="card">--}}
    {{--                                    <div class="card-body">--}}
    {{--                                        <h5 class="card-title">{{ $product->title }}</h5>--}}
    {{--                                        <p class="card-text">{{ $product->description }}</p>--}}
    {{--                                        <a href="{{ route('single.product', $product->slug )}}" class="btn btn-primary">جزئیات محصول</a>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}



    <div class="ads-grid">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">Kitchen Products
                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <!-- //tittle heading -->
            <!-- product left -->
            @include('main::client.layouts.sidebar')
            <!-- //product left -->
            <!-- product right -->
            <div class="agileinfo-ads-display col-md-9 w3l-rightpro">
                <div class="wrapper">
                    <!-- first section -->
                    @foreach($products->chunk(3) as $row)
                        <div class="product-sec1">
                            @foreach($row as $product)
                                <div class="col-xs-4 product-men">
                                    <div class="men-pro-item simpleCart_shelfItem">
                                        <div class="men-thumb-item">
                                            <img src="{{asset('client/images/k1.jpg')}}" alt="">
                                            <div class="men-cart-pro">
                                                <div class="inner-men-cart-pro">
                                                    <a href="{{ route('single.product', $product->slug )}}"
                                                       class="link-product-add-cart">Quick View</a>
                                                </div>
                                            </div>
                                            <span class="product-new-top">New</span>
                                        </div>
                                        <div class="item-info-product ">
                                            <h4>
                                                <a href="{{ route('single.product', $product->slug )}}">{{$product->name}}</a>
                                            </h4>
                                            <div class="info-product-price">
                                                <span
                                                    class="item_price">{{number_format($product->firstValue->priceWithDiscount ?? $product->firstValue->price ?? 0)}}</span>
                                                <del>{{number_format($product->firstValue->price ?? 0)}}</del>
                                            </div>
                                            <div
                                                class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                                <form action="{{route('cart.add', $product->id)}}" method="post">
                                                    @csrf
                                                    <fieldset>
                                                        <input type="hidden" name="add" value="1"/>
                                                        <input type="hidden" name="value"
                                                               value="{{$product->firstValue->id ?? 0}}"/>
                                                        <input type="hidden" name="attribute_id"
                                                               value="{{$product->firstAttribute->id ?? 0}}"/>
                                                        <input type="submit" name="submit" value="Add to cart"
                                                               class="button"/>
                                                    </fieldset>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="clearfix"></div>
                        </div>
                    @endforeach
                    <!-- //first section -->
                </div>
            </div>
            <!-- //product right -->
        </div>
    </div>
@endsection

@slot('breadcrumbs')
    <div class="services-breadcrumb">
        <div class="agile_inner_breadcrumb">
            <div class="container">
                <ul class="w3_short">
                    <li>
                        <a href="index.html">Home</a>
                        <i>|</i>
                    </li>
                    <li>Kitchen Products</li>
                </ul>
            </div>
        </div>
    </div>
@endslot
