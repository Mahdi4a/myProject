@can('show-products')
    <li class="nav-item has-treeview {{ isActive(['admin.product.index','admin.product.create','admin.product.edit'],'menu-open') }} ">
        <a href="#"
           class="nav-link {{ isActive(['admin.product.index','admin.product.create','admin.product.edit']) }}">
            <i class="nav-icon fa fa-product-hunt"></i>
            <p>
                محصولات
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.product.index') }}" class="nav-link {{ isActive('admin.product.index') }}">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست محصولات</p>
                </a>
            </li>
            @can('create-user')
                <li class="nav-item">
                    <a href="{{ route('admin.product.create') }}"
                       class="nav-link {{ isActive('admin.product.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد محصول جدید</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
