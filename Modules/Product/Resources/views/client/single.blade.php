@extends('main::client.master')
@section('content')
    {{--    @auth--}}
    {{--        <div class="modal fade" id="sendComment">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>--}}
    {{--                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <form action="{{route('store.comment')}}" method="post" id="commentForm">--}}
    {{--                    @csrf--}}
    {{--                    <div class="modal-body">--}}
    {{--                            <input type="hidden" name="comment_id" value="{{$product->id}}">--}}
    {{--                            <input type="hidden" name="comment_type" value="{{get_class($product)}}">--}}
    {{--                            <input type="hidden" name="parent_id" id="parent_id" value="0">--}}
    {{--                            <div class="form-group">--}}
    {{--                                <label for="message-text" class="col-form-label">پیام دیدگاه:</label>--}}
    {{--                                <textarea class="form-control" name="comment" id="message-text"></textarea>--}}
    {{--                            </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>--}}
    {{--                        <button type="submit" class="btn btn-primary">ارسال نظر</button>--}}
    {{--                    </div>--}}
    {{--                </form>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    @endauth--}}
    {{--    <div class="container">--}}
    {{--        <div class="row justify-content-center">--}}
    {{--            <div class="col-md-12">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header d-flex justify-content-between">--}}
    {{--                        {{ $product->title }}--}}
    {{--                        <form action="{{route('cart.add', $product->id)}}" method="post">--}}
    {{--                            @csrf--}}
    {{--                            <button class="btn btn-sm btn-danger">اضافه کردن به سبد</button>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}

    {{--                    <div class="card-body">--}}
    {{--                        {{ $product->description }}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="row">--}}
    {{--            <div class="col">--}}
    {{--                <div class="d-flex align-items-center justify-content-between">--}}
    {{--                    <h4 class="mt-4">بخش نظرات</h4>--}}
    {{--                    @auth--}}
    {{--                        <span class="btn btn-sm btn-primary openCommentModal"  data-toggle="modal" data-target="#sendComment" data-id="0" data-type="product">ثبت نظر جدید</span>--}}
    {{--                    @endauth--}}
    {{--                </div>--}}
    {{--                @include('layouts.comments', ['comments' => $product->comments])--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--
    {{----}}

    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    <div class="banner-bootom-w3-agileits">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">Single Page
                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <!-- //tittle heading -->
            <div class="col-md-5 single-right-left ">
                <div class="grid images_3_of_2">
                    <div class="flexslider">
                        <ul class="slides">
                            <li data-thumb="images/si.jpg">
                                <div class="thumb-image">
                                    <img src="{{ asset("client/images/si.jpg") }}" data-imagezoom="true"
                                         class="img-responsive" alt=""></div>
                            </li>
                            <li data-thumb="images/si2.jpg">
                                <div class="thumb-image">
                                    <img src="{{ asset("client/images/si2.jpg") }}" data-imagezoom="true"
                                         class="img-responsive" alt=""></div>
                            </li>
                            <li data-thumb="images/si3.jpg">
                                <div class="thumb-image">
                                    <img src="{{ asset("client/images/si3.jpg") }}" data-imagezoom="true"
                                         class="img-responsive" alt=""></div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 single-right-left simpleCart_shelfItem">
                <h3>{{$product->name}}</h3>
                <div class="rating1">
					<span class="starRating">
						<input id="rating5" type="radio" name="rating" value="5">
						<label for="rating5">5</label>
						<input id="rating4" type="radio" name="rating" value="4">
						<label for="rating4">4</label>
						<input id="rating3" type="radio" name="rating" value="3" checked="">
						<label for="rating3">3</label>
						<input id="rating2" type="radio" name="rating" value="2">
						<label for="rating2">2</label>
						<input id="rating1" type="radio" name="rating" value="1">
						<label for="rating1">1</label>
					</span>
                </div>
                <p>
                    <span class="item_price"
                          id="item_discounted_price">{{ number_format($product->firstValue->priceWithDiscount ?? $product->firstValue->price ?? 0) }}</span>
                    <del id="item_price">{{ number_format($product->firstValue->price ?? 0) }}</del>
                    <label>Free delivery</label>
                </p>
                <p>{{ \Modules\Cart\Service\Cart::count($product,$product->firstAttribute->id,$product->firstValue->id)}}</p>
                {!! $product->description !!}
                <div class="occasion-cart">
                    <label for="attributes">ویژگی</label>
                    <select name="attributes" id="attributes" class="attribute-select form-control">
                        @foreach($product->attributes as $attribute)
                            <option
                                value="{{$attribute->id}}" {{ $attribute->id === ($product->firstAttribute->id) ? "selected" : "" }}>{{$attribute->name}}</option>
                        @endforeach
                    </select>
                    <label for="values">مقدار ویژگی</label>
                    <select name="values" id="values" class="value-select form-control">
                        @foreach($product->firstAttribute->values as $value)
                            <option
                                value="{{$value->id}}" {{ $value->id === $product->firstValue->value_id ? "selected" : "" }}>{{$value->value}}</option>
                        @endforeach
                    </select>
                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        @if(!Module::isDisabled('Cart'))
                            @include('cart::client.addToCart',['data' => $product])
                        @endif

                    </div>

                </div>

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
                        <li>Single Page</li>
                    </ul>
                </div>
            </div>
        </div>
    @endslot
@endsection
