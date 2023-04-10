@component('admin.layouts.content',['title' => 'ویرایش سفارش'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index',['type'=>request('type')]) }}">لیست سفارش
                های {{orderTypes(request('type'))}}</a></li>
        <li class="breadcrumb-item active">ویرایش سفارش</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش سفارش</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.orders.update' , $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id" class="col-sm-2 control-label">آیدی سفارش</label>
                            <input type="text" name="id" value="{{ (old('id') ?? $order->id) ?? "" }}"
                                   class="form-control" id="id" disabled
                                   placeholder="آیدی سفارش را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="finalPrice" class="col-sm-2 control-label">هزینه سفارش</label>
                            <input type="text" name="finalPrice"
                                   value="{{ (old('finalPrice') ?? $order->finalPrice) ?? "" }}"
                                   class="form-control" id="finalPrice" disabled
                                   placeholder="هزینه سفارش را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">وضعیت سفارش</label>
                            <select name="status" id="status" class="form-control">
                                @foreach(orderTypes() as $key => $orderType)
                                    <option
                                        value="{{$key}}"
                                        {{ $key === old('status',$order->status) ? 'selected' : ''  }}>
                                        {{$orderType}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tracking_serial" class="col-sm-2 control-label">کد پیگیری</label>
                            <input type="text" name="tracking_serial"
                                   value="{{ (old('tracking_serial') ?? $order->tracking_serial) ?? "" }}"
                                   class="form-control" id="tracking_serial"
                                   placeholder="کد پیگیری را وارد کنید">
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش سفارش</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

