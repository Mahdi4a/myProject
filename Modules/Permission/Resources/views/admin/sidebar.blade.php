@canany(['show-permissions','show-roles'])
    <li class="nav-item has-treeview {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit'],'menu-open') }} ">
        <a href="#"
           class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit']) }}">
            <i class="nav-icon fa fa-server"></i>
            <p>
                اجازه دسترسی
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('show-permissions')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}"
                       class="nav-link {{ isActive('admin.permissions.index') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست دسترسی ها</p>
                    </a>
                </li>
            @endcan
            @can('create-permission')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.create') }}"
                       class="nav-link {{ isActive('admin.permissions.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد دسترسی جدید</p>
                    </a>
                </li>
            @endcan
            @can('show-roles')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive('admin.roles.index') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>لیست نقش ها</p>
                    </a>
                </li>
            @endcan
            @can('create-role')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.create') }}" class="nav-link {{ isActive('admin.roles.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد نقش جدید</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
