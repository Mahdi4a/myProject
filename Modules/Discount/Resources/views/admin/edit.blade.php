@component('main::admin.layouts.content',['title' => 'ویرایش کد تخفیف'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست کد تخفیف</a></li>
        <li class="breadcrumb-item active">ویرایش کد تخفیف</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش کد تخفیف</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST"
                      action="{{ route('admin.discount.update', $discount->id) }}">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                            <label for="code" class="col-sm-2 control-label">کد تخفیف<span
                                    style="color:red">*</span></label>
                            <input type="text" name="code" value="{{ old('code' , $discount->code) ?? "" }}"
                                   class="form-control" id="code"
                                   placeholder="کد تخفیف را وارد کنید">
                            {!! $errors->first('code', '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('percent') ? 'has-error' : ''}}">
                            <label for="percent" class="col-sm-2 control-label">درصد<span
                                    style="color:red">*</span></label>
                            <input type="text" name="percent" value="{{ old('percent' , $discount->percent) ?? "" }}"
                                   class="form-control" id="percent"
                                   placeholder="درصد را وارد کنید">
                            {!! $errors->first('percent', '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('expired_at') ? 'has-error' : ''}}">

                            <label for="expired_at" class="col-sm-2 control-label form_jDate">تاریخ انقضا<span
                                    style="color:red">*</span></label>
                            <input type="text" name="expired_at"
                                   value="{{ old('expired_at' , $discount->expired_at) ?? "" }}"
                                   class="form-control" id="expired_at"
                                   placeholder="تاریخ انقضا را وارد کنید">
                            {!! $errors->first('expired_at', '<p class="help-block" style="color:red">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label for="users" class="col-sm-2 control-label">کاربران</label>
                            <select name="users[]" id="users" multiple="multiple" class="form-control selectSearch">
                                @foreach($users as $user)
                                    <option
                                        value="{{$user->id}}" {{ in_array($user->id, old('users', array_flip($discount->allUsers())), true) ? 'selected' : ''  }} >{{$user->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">محصولات</label>
                            <select name="products[]" id="products" multiple="multiple"
                                    class="form-control selectSearch">
                                @foreach($products as $product)
                                    <option
                                        value="{{$product->id}}" {{ in_array($product->id, old('products' , array_flip($discount->allProducts())), true) ? 'selected' : ''  }} >{{$product->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-check">
                            <label for="categories" class="form-check-label">دسته بندی ها</label>
                            <select name="categories[]" id="categories" multiple="multiple"
                                    class="form-control selectSearch">
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{ in_array($category->id, old('categories',array_flip($discount->allCategories())), true) ? 'selected' : ''  }} >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش کد تخفیف</button>
                        <a href="{{ route('admin.discount.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent

