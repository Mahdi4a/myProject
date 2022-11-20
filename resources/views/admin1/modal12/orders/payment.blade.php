@component('admin.layouts.content',['title' => 'لیست پرداخت ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">سفارش شماره {{$order->id}}</li>
        <li class="breadcrumb-item">لیست پرداخت ها</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">لیست پرداخت ها</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">

                        <label for="search"> </label>
                        <input type="text" id="search" name="search" value="{{request('search')}}"
                               class="form-control float-right" placeholder="جستجو">

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
                    <th>آیدی پرداخت</th>
                    <th>شماره پرداخت</th>
                    <th>وضعیت پرداخت</th>
                    <th>زمان ثبت پرداخت</th>
                </tr>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{$payment->id}}</td>
                        <td>{{$payment->resourceNumber}}</td>
                        <td>{{$payment->status ? 'پرداخت شده' : "پرداخت نشده"}}</td>
                        <td>{{jdate($payment->created_at)->format("%Y-%m-%d")}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$payments->appends(['search'=> request('search')])->render()}}
        </div>
    </div>

@endcomponent
