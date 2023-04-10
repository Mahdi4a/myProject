@can('show-categories')
    <li class="nav-item has-treeview {{ isActive(['admin.category.index','admin.category.create','admin.category.edit'],'menu-open') }} ">
        <a href="#"
           class="nav-link {{ isActive(['admin.category.index','admin.category.create','admin.category.edit']) }}">
            <i class="nav-icon fa fa-id-card"></i>
            <p>
                دسته بندی ها
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.category.index') }}" class="nav-link {{ isActive('admin.category.index') }}">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست دسته بندی ها</p>
                </a>
            </li>
            @can('create-categories')
                <li class="nav-item">
                    <a href="{{ route('admin.category.create') }}"
                       class="nav-link {{ isActive('admin.category.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد دسته بندی جدید</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
