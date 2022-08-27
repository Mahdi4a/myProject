<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">حسام موسوی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.index')}}" class="nav-link {{ isActive('admin.index') }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>پنل ادمین</p>
                        </a>
                    </li>
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
                    @can('show-products')
                        <li class="nav-item has-treeview {{ isActive(['admin.product.index','admin.product.create','admin.product.edit'],'menu-open') }} ">
                        <a href="#" class="nav-link {{ isActive(['admin.product.index','admin.product.create','admin.product.edit']) }}">
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
                                    <a href="{{ route('admin.product.create') }}" class="nav-link {{ isActive('admin.product.create') }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>ایجاد محصول جدید</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('show-categories')
                        <li class="nav-item has-treeview {{ isActive(['admin.category.index','admin.category.create','admin.category.edit'],'menu-open') }} ">
                        <a href="#" class="nav-link {{ isActive(['admin.category.index','admin.category.create','admin.category.edit']) }}">
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
                            @can('create-user')
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.create') }}" class="nav-link {{ isActive('admin.category.create') }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>ایجاد دسته بندی جدید</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @canany(['show-permissions','show-roles'])
                        <li class="nav-item has-treeview {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit'],'menu-open') }} ">
                        <a href="#" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit']) }}">
                            <i class="nav-icon fa fa-server"></i>
                            <p>
                                اجازه دسترسی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('show-permissions')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive('admin.permissions.index') }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست دسترسی ها</p>
                                    </a>
                                </li>
                            @endcan
                            @can('create-permission')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.create') }}" class="nav-link {{ isActive('admin.permissions.create') }}">
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
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
