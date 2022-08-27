@component('admin.layouts.content',['title' => 'لیست نقش ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست نقش ها</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">نقش ها</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" value="{{request('search')}}" class="form-control float-right" placeholder="جستجو">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <div class="btn-group-sm mr-1">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-info">ایجاد نقش جدید</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>نام</th>
                    <th>توضیح نقش</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->name}}</td>
                        <td>{{$role->label}}</td>
                        <td class="d-flex">
                            @can('delete-role')
                                <form action="{{ route('admin.roles.destroy' , $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-role')
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$roles->render()}}
        </div>
    </div>

@endcomponent
