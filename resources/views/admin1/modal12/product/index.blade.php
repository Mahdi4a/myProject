@component('admin.layouts.content',['title' => 'لیست محصولات'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست محصولات</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">محصولات</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" value="{{request('search')}}" class="form-control float-right"
                               placeholder="جستجو">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @can('create-product')
                    <div class="btn-group-sm mr-1">
                        <a href="{{ route('admin.product.create') }}" class="btn btn-info">ایجاد محصول جدید</a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>آی دی محصول</th>
                    <th>نام</th>
                    <th>دسته بندی</th>
                    <th>قیمت</th>
                    <th>تخفیف</th>
                    <th>موجودی</th>
                    <th>وضعیت</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->category ?? 'nadarad'}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->discount}}</td>
                        <td>{{$product->inventory}}</td>
                        <td>
                            <span class="badge badge-{{ $product->status ? "success" : "danger" }}">
                                {{ $product->status ? "تایید شده" : "تایید نشده" }}
                            </span>
                        </td>
                        <td class="d-flex">
                            @can('delete-product')
                                <form action="{{ route('admin.product.destroy' , ['product' => $product->id ]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-product')
                                <a href="{{ route('admin.product.edit', [ 'product' => $product->id ]) }}"
                                   class="btn btn-sm btn-primary ml-1">ویرایش</a>
                            @endcan
                        </td>
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
