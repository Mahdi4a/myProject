@component('admin.layouts.content',['title' => 'جزئیات سفارش'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">سفارش شماره {{$order->id}}</li>
        <li class="breadcrumb-item">جزئیات سفارش</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">جزئیات سفارش</h3>

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
                    <th>آیدی محصول</th>
                    <th>نام محصول</th>
                    <th>تعداد محصول</th>
                    <th>قیمت ثبت شده</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name . " (" .$product->pivot->attribute->name ." : " .$product->pivot->value->value . ")"}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td>{{$product->pivot->price}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$products->appends(['search'=> request('search')])->render()}}
        </div>
    </div>

@endcomponent
