@component('admin.layouts.content',['title' => 'ایجاد کاربر'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربرات</a></li>
        <li class="breadcrumb-item active">ایجاد کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">ایمیل</label>
                            <input type="email" name="email" value="{{ old('email') ?? "" }}" class="form-control" id="inputEmail"
                                   placeholder="ایمیل را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" value="{{ old('name') ?? "" }}" class="form-control" id="inputName"
                                   placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">پسورد</label>
                            <input type="password" name="password" value="{{ old('password') ?? "" }}" class="form-control" id="inputPassword"
                                   placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword_confirmation" class="col-sm-2 control-label">پسورد</label>
                            <input type="password" value="{{ old('password_confirmation') ?? "" }}" name="password_confirmation" class="form-control"
                                   id="inputPassword_confirmation" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="verify" id="verify" class="form-check-input">
                            <label for="verify" class="form-check-label">اکانت فعال باشد</label>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت کاربر</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

