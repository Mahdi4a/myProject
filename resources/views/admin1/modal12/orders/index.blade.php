@component('admin.layouts.content',['title' => 'لیست سفارشات'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست سفارشات</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">سفارشات</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="hidden" name="type" value="{{request('type')}}">
                        <input type="text" name="search" value="{{request('search')}}" class="form-control float-right"
                               placeholder="جستجو">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>آیدی سفارش</th>
                    <th>نام کاربر</th>
                    <th>هزینه سفارش</th>
                    <th>وضعیت سفارش</th>
                    <th>شماره پیگیری</th>
                    <th>زمان ثبت سفارش</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->user->name}}</td>
                        <td>{{number_format($order->finalPrice)}}</td>
                        <td>{{orderTypes($order->status)}}</td>
                        <td>{{$order->tracking_serial}}</td>
                        <td>{{jdate($order->created_at)->ago()}}</td>
                        <td class="d-flex">
                            @can('view-order-payment')
                                <a href="{{ route('admin.orders.payment', ['type' => request('type'),'order'=>$order->id]) }}"
                                   class="btn btn-sm btn-info">مشاهده پرداخت های سفارش</a>
                            @endcan
                            @can('view-order')
                                <a href="{{ route('admin.orders.show', ['type' => request('type'),'order'=>$order->id]) }}"
                                   class="btn btn-sm btn-warning">مشاهده جزئیات سفارش</a>
                            @endcan
                            @can('edit-order')
                                <a href="{{ route('admin.orders.edit', ['type' => request('type'),'order'=>$order->id]) }}"
                                   class="btn btn-sm btn-primary">ویرایش</a>
                            @endcan
                            @can('delete-order')
                                <form action="{{ route('admin.orders.destroy' , $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$orders->appends(['search'=> request('search'),'type'=> request('type')])->render()}}
        </div>
    </div>

@endcomponent
