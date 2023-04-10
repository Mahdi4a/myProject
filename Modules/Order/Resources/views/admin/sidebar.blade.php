@can('show-orders')
    <li class="nav-item has-treeview {{ isActive(['admin.orders.index','admin.orders.show','admin.orders.edit'],'menu-open') }} ">
        <a href="#" class="nav-link {{ isActive(['admin.orders.index','admin.orders.show','admin.orders.edit']) }}">
            <i class="nav-icon fa fa-id-card"></i>
            <p>
                سفارشات
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @foreach(orderTypes() as $key => $orderType)
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index' , ['type'=>$key]) }}"
                       class="nav-link {{ isUrl(route('admin.orders.index' , ['type'=>$key])) }}">
                        <i class="fa fa-circle-o nav-icon text-{{orderStatusClass($key)}}"></i>
                        <p> {{$orderType}}
                            <span
                                class="badge badge-{{orderStatusClass($key)}} right">{{Modules\Order\Entities\Order::whereStatus($key)->count()}}</span>
                        </p>

                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endcan
