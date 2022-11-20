@component('admin.layouts.content',['title' => 'ایجاد دسترسی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست دسترسی ها</a></li>
        <li class="breadcrumb-item active">ایجاد دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.permissions.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">عنوان دسترسی</label>
                            <input type="text" name="name" value="{{ old('name') ?? "" }}" class="form-control"
                                   id="inputName"
                                   placeholder="عنوان دسترسی را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inputLabel" class="col-sm-2 control-label">توضیح دسترسی</label>
                            <input type="text" name="label" value="{{ old('label') ?? "" }}" class="form-control"
                                   id="inputLabel"
                                   placeholder="توضیح دسترسی را وارد کنید">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت دسترسی</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

