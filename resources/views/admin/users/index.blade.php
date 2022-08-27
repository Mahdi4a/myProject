@component('admin.layouts.content',['title' => 'لیست کاربران'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست کاربرات</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">کاربران</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" value="{{request('search')}}" class="form-control float-right" placeholder="جستجو">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @can('create-user')
                    <div class="btn-group-sm mr-1">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-info">ایجاد کاربر جدید</a>
                    </div>
                @endcan
                @can('show-staff-users')
                    <div class="btn-group-sm mr-1">
                        <a href="{{ request()->fullUrlWithQuery(['admin'=>1]) }}" class="btn btn-warning">کاربران مدیر</a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>آی دی کاربر</th>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>وضعیت ایمیل</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><span
                                class="badge badge-{{ $user->email_verified_at ? "success" : "danger" }}">{{ $user->email_verified_at ? "تایید شده" : "تایید نشده" }}</span>
                        </td>
                        <td class="d-flex">
                            @can('delete-user')
                                <form action="{{ route('admin.users.destroy' , ['user' => $user->id ]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-user')
                                <a href="{{ route('admin.users.edit', [ 'user' => $user->id ]) }}" class="btn btn-sm btn-primary ml-1">ویرایش</a>
                            @endcan
                            @if($user->is_staff)
                                @can('show-user-permissions')
                                    <a href="{{ route('admin.users.permissions', [ 'user' => $user->id ]) }}" class="btn btn-sm btn-warning">دسترسی ها</a>
                                @endcan
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$users->render()}}
        </div>
    </div>

@endcomponent
