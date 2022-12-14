@component('admin.layouts.content',['title' => 'ایجاد نقش'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست نقش ها</a></li>
        <li class="breadcrumb-item active">ایجاد نقش</li>
    @endslot

    @slot('script')
        <script>
            $("#permissions").select2({
                'placeholder': 'یکی از دسترسی ها را انتخاب کنید',
            });
        </script>
    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد نقش</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">عنوان نقش</label>
                            <input type="text" name="name" value="{{ old('name') ?? "" }}" class="form-control"
                                   id="inputName"
                                   placeholder="عنوان نقش را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inputLabel" class="col-sm-2 control-label">توضیح نقش</label>
                            <input type="text" name="label" value="{{ old('label') ?? "" }}" class="form-control"
                                   id="inputLabel"
                                   placeholder="توضیح نقش را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="permissions" class="col-sm-2 control-label">دسترسی ها</label>
                            <select name="permissions[]" id="permissions" multiple="multiple" class="form-control">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}">{{$permission->name}}
                                        - {{$permission->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت نقش</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

