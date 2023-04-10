@can('show-discounts')
    <li class="nav-item has-treeview {{ isActive(['admin.discount.index','admin.discount.create','admin.discount.edit'],'menu-open') }} ">
        <a href="#"
           class="nav-link {{ isActive(['admin.discount.index','admin.discount.create','admin.discount.edit']) }}">
            <i class="nav-icon fa fa-user"></i>
            <p>
                تخفیفات
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.discount.index') }}" class="nav-link {{ isActive('admin.discount.index') }}">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست تخفیفات</p>
                </a>
            </li>
            @can('create-discount')
                <li class="nav-item">
                    <a href="{{ route('admin.discount.create') }}"
                       class="nav-link {{ isActive('admin.discount.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد کد تخفیف جدید</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
