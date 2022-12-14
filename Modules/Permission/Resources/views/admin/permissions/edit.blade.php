@component('main::admin.layouts.content',['title' => 'ویرایش دسترسی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست دسترسی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST"
                      action="{{ route('admin.permissions.update' , $permission->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group {{ $errors->has("name") ? 'has-error' : ''}}">
                            <label for="inputName" class="col-sm-2 control-label">عنوان دسترسی</label>
                            <input type="text" name="name" value="{{ (old('name') ?? $permission->name) ?? "" }}"
                                   class="form-control" id="inputName"
                                   placeholder="عنوان دسترسی را وارد کنید">
                            {!! $errors->first("name", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has("label") ? 'has-error' : ''}}">
                            <label for="inputLabel" class="col-sm-2 control-label">توضیح دسترسی</label>
                            <input type="text" name="label" value="{{ (old('label') ?? $permission->label) ?? "" }}"
                                   class="form-control" id="inputLabel"
                                   placeholder="توضیح دسترسی را وارد کنید">
                            {!! $errors->first("label", '<p class="help-block" style="color:red">:message</p>') !!}
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

