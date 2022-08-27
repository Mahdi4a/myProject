@component('admin.layouts.content',['title' => 'ایجاد محصول'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ایجاد محصول</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.product.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">دسته بندی</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">یک گزینه را انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" value="{{ old('title') ?? "" }}" class="form-control" id="title"
                                   placeholder="عنوان را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="text" name="price" value="{{ old('price') ?? "" }}" class="form-control" id="price"
                                   placeholder="قیمت را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="discount" class="col-sm-2 control-label">تخفیف</label>
                            <input type="text" name="discount" value="{{ old('discount') ?? "" }}" class="form-control" id="discount"
                                   placeholder="تخفیف را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="text" name="inventory" value="{{ old('inventory') ?? "" }}" class="form-control" id="inventory"
                                   placeholder="موجودی را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description') ?? "" }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="status" id="status" class="form-check-input">
                            <label for="verify" class="form-check-label">محصول فعال باشد</label>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت محصول</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

