@component('main::admin.layouts.content',['title' => 'لیست ماژول ها'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست ماژول ها</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ماژول ها</h3>

            <div class="card-tools d-flex">

                {{--                @can('create-product')--}}
                {{--                    <div class="btn-group-sm mr-1">--}}
                {{--                        <a href="{{ route('admin.product.create') }}" class="btn btn-info">ایجاد محصول جدید</a>--}}
                {{--                    </div>--}}
                {{--                @endcan--}}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body ">
            <div class="row">
                @foreach($modules as $module)
                    @php($moduleData = new \Nwidart\Modules\Json($module->getExtraPath('module.json')))
                    <div class="col-sm-2 border-solid-1">
                        <div class="mt-3">
                            <h4>{{$moduleData->get('alias')}}</h4>
                            <p>{{$moduleData->get('description')}}</p>
                        </div>
                        @can('delete-product')
                            @if($moduleData->get('canDisable'))
                                @if(Module::isDisabled($module->getName()))
                                    <form action="{{route('admin.modules.enable' , $module->getName())}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-primary">فعال کردن</button>
                                    </form>
                                @else
                                    <form action="{{route('admin.modules.disable' , $module->getName())}}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-danger">غیر فعال کردن</button>
                                    </form>
                                @endif
                            @endif
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{--            {{$products->appends(['search'=> request('search')])->render()}}--}}
        </div>
    </div>

@endcomponent
