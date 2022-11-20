@can('show-users')
    <li class="nav-item has-treeview {{ isActive(['admin.users.index','admin.users.create','admin.users.edit'],'menu-open') }} ">
        <a href="#" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit']) }}">
            <i class="nav-icon fa fa-users"></i>
            <p>
                کاربران
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive('admin.users.index') }}">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست کاربران</p>
                </a>
            </li>
            @can('create-user')
                <li class="nav-item">
                    <a href="{{ route('admin.users.create') }}" class="nav-link {{ isActive('admin.users.create') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>ایجاد کاربر جدید</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
