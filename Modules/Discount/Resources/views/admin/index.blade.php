@component('main::admin.layouts.content',['title' => 'لیست تخفیف ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست تخفیف ها</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">لیست تخفیف ها</h3>

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
                @can('create-discount')
                    <div class="btn-group-sm mr-1">
                        <a href="{{ route('admin.discount.create') }}" class="btn btn-info">ایجاد تخفیف جدید</a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>آی دی</th>
                    <th>کد تخفیف</th>
                    <th>درصد تخفیف</th>
                    <th>تاریخ انقضا</th>
                    <th>کاربران</th>
                    <th>محصولات</th>
                    <th>دسته بندی ها</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($discounts as $discount)
                    <tr>
                        <td>{{$discount->id}}</td>
                        <td>{{$discount->code}}</td>
                        <td>{{$discount->percent}}</td>
                        <td>{{jdate($discount->expired_at)->ago()}}</td>
                        <td>{{$discount->allUsers() ? implode(',',$discount->allUsers()) : 'همه کاربران'}}</td>
                        <td>{{$discount->allProducts() ? implode(',',$discount->allProducts()) : 'همه محصولات'}}</td>
                        <td>{{$discount->allCategories() ? implode(',',$discount->allCategories()) : 'همه دسته بندی ها'}}</td>
                        <td class="d-flex">
                            @can('delete-discount')
                                <form action="{{ route('admin.discount.destroy' , $discount->id ) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-discount')
                                <a href="{{ route('admin.discount.edit', $discount->id ) }}"
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
            {{$discounts->appends(['search'=> request('search')])->render()}}
        </div>
    </div>

@endcomponent
