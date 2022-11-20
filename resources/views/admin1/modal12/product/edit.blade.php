@component('admin.layouts.content',['title' => 'ویرایش محصول'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot
    @slot('script')
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
            $("#category").select2({
                'placeholder': 'یکی از دسته بندی ها را انتخاب کنید',
            });
        </script>
        @include('admin.layouts.fileManagerJavaScript')

    @endslot
    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.product.update',$product->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">دسته بندی</label>
                            <select name="category[]" id="category" multiple="multiple" class="form-control">
                                <option value="">یک گزینه را انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option
                                        {{in_array($category->id, $product->categories->pluck('id')->toArray(), true) ? "selected":""}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" value="{{ old('title') ?? $product->title }}"
                                   class="form-control" id="title"
                                   placeholder="عنوان را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="col-sm-2 control-label">توضیحات سئو</label>
                            <textarea name="seo_description" id="seo_description" class="form-control" cols="30"
                                      rows="10">{{ old('seo_description') ?? $product->seo_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" value="{{ old('name') ?? $product->name }}"
                                   class="form-control" id="name"
                                   placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea placeholder="توضیحات را وارد کنید" name="description" id="description"
                                      class="form-control" cols="30"
                                      rows="10">{!! old('description') ?? $product->description !!}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" {{$product->status ? 'checked':""}} name="status" id="status"
                                   class="form-check-input">
                            <label for="status" class="form-check-label">محصول فعال باشد</label>
                        </div>
                    </div>
                    <h6>تصاویر</h6>
                    <hr>
                    <button class="btn btn-sm btn-primary mb-2" type="button" id="add_product_image">تصویر جدید
                    </button>
                    <div id="mainImageDiv">
                        <div class="form-group">
                            <label for="image_label" class="col-sm-2 control-label">تصویر</label>
                            @foreach($product->images as $key => $image)
                                <div class="input-group imageDiv" id="{{$key === 0 ? 'imageTemplate': ''}}">
                                    <input type="text" id="image_label" class="form-control" name="image[]"
                                           aria-label="Image" value="{{$image->address}}"
                                           aria-describedby="button-image">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary button-image" type="button"
                                                id="button-image">انتخاب
                                        </button>
                                        <img src="{{$image->address ?? asset('default/notFound.jpeg')}}" height="50"
                                             id="preview" alt="">
                                        <button type="button" class="btn btn-outline-secondary deleteImageDiv">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h6>ویژگی ها</h6>
                    <hr>
                    <button class="btn btn-sm btn-danger mb-2" type="button" id="add_product_attribute">ویژگی جدید
                    </button>
                    <div id="attribute_section">
                        @foreach(old('attributes' , $product->attributes) as $key => $item)
                            <div class="row" id="{{$key === 0 ? 'attributeTemplate': ''}}">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="attributes" class="control-label">ویژگی
                                            <select name="attributes[]"
                                                    class="attribute-select tag-select form-control">
                                                <option value="">یک گزینه را انتخاب کنید</option>
                                                @foreach($attributes as $attribute)
                                                    <option
                                                        value="{{$attribute->name}}" {{ $attribute->name === ($item->name ?? $item) ? "selected" : "" }}>{{$attribute->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="values" class="control-label">مقدار
                                            <select name="values[]" class="value-select tag-select form-control">
                                                <option value="">یک گزینه را انتخاب کنید</option>
                                                @foreach(old('values' , $item->values) as $value)
                                                    <option
                                                        value="{{$value->value}}" {{ $value->id === $item->pivot->value_id ? "selected" : "" }}>{{$value->value}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="price" class="control-label">قیمت
                                            <input type="text" name="price[]"
                                                   value="{{old('price')[$key] ?? $item->pivot->value->price }}"
                                                   class="form-control"
                                                   placeholder="قیمت را وارد کنید">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="discount" class="control-label">تخفیف
                                            <input type="text" name="discount[]"
                                                   value="{{old('discount')[$key] ?? $item->pivot->value->discount}}"
                                                   class="form-control"
                                                   placeholder="تخفیف را وارد کنید">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="inventory" class="control-label">موجودی
                                            <input type="text" name="inventory[]"
                                                   value="{{old('inventory')[$key] ?? $item->pivot->value->inventory}}"
                                                   class="form-control"
                                                   placeholder="موجودی را وارد کنید">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="inventory" class="control-label"></label>
                                        <button type="button" class="form-control deleteAttributeDiv">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

