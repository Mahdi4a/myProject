@component('admin.layouts.content',['title' => 'لیست دسته بندی ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست دسته بندی ها</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">دسته بندی ها</h3>

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
                @can('create-category')
                    <div class="btn-group-sm mr-1">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-info">ایجاد محصول جدید</a>
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
                    <th>دسته بندی پدر</th>
                    <th>وضعیت</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->parentCategory->name ?? ''}}</td>
                        <td>
                            <span class="badge badge-{{ $category->status ? "success" : "danger" }}">
                                {{ $category->status ? "تایید شده" : "تایید نشده" }}
                            </span>
                        </td>
                        <td class="d-flex">
                            @can('delete-category')
                                <form action="{{ route('admin.category.destroy' , ['category' => $category->id ]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-category')
                                <a href="{{ route('admin.category.edit', [ 'category' => $category->id ]) }}"
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
            {{$categories->appends(['search'=> request('search')])->render()}}
        </div>
    </div>

@endcomponent
