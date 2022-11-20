@component('main::admin.layouts.content',['title' => 'ایجاد دسته بندی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ایجاد دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد دسته بندی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.category.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group {{ $errors->has("category") ? 'has-error' : ''}}">
                            <label for="category" class="col-sm-2 control-label">دسته بندی</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">یک گزینه را انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first("category", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has("title") ? 'has-error' : ''}}">
                            <label for="title" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" value="{{ old('title') ?? "" }}" class="form-control"
                                   id="title"
                                   placeholder="عنوان را وارد کنید">
                            {!! $errors->first("title", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has("seo_description") ? 'has-error' : ''}}">
                            <label for="seo_description" class="col-sm-2 control-label">توضیحات سئو</label>
                            <textarea name="seo_description" id="seo_description" class="form-control" cols="30"
                                      rows="10">{{ old('seo_description') ?? "" }}</textarea>
                            {!! $errors->first("seo_description", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has("name") ? 'has-error' : ''}}">
                            <label for="name" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" value="{{ old('name') ?? "" }}" class="form-control"
                                   id="name"
                                   placeholder="نام را وارد کنید">
                            {!! $errors->first("name", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has("description") ? 'has-error' : ''}}">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea name="description" id="description" class="form-control" cols="30"
                                      rows="10">{{ old('description') ?? "" }}</textarea>
                            {!! $errors->first("description", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-check {{ $errors->has("status") ? 'has-error' : ''}}">
                            <input type="checkbox" name="status" id="status" class="form-check-input">
                            <label for="status" class="form-check-label">دسته بندی فعال باشد</label>
                            {!! $errors->first("status", '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت دسته بندی</button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

