@component('admin.layouts.content',['title' => 'ویرایش دسته بندی'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته بندی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسته بندی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.category.update',$category->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">دسته بندی</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">یک گزینه را انتخاب کنید</option>
                                @foreach($categories as $value)
                                    <option
                                        {{$category->category_id === $value->id ? "selected" : ""}} value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" value="{{ old('title') ?? $category->title }}"
                                   class="form-control" id="title"
                                   placeholder="عنوان را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="col-sm-2 control-label">توضیحات سئو</label>
                            <textarea name="seo_description" id="seo_description" class="form-control" cols="30"
                                      rows="10">{{ old('seo_description') ?? $category->seo_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="name" value="{{ old('name') ?? $category->name }}"
                                   class="form-control" id="name"
                                   placeholder="عنوان را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea placeholder="توضیحات را وارد کنید" name="description" id="description"
                                      class="form-control" cols="30"
                                      rows="10">{{ old('description') ?? $category->description }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="status" id="status" class="form-check-input">
                            <label for="status" {{$category->status ? "checked" :""}} class="form-check-label">دسته بندی
                                فعال باشد</label>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دسته بندی</button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

