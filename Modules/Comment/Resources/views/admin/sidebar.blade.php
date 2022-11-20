@canany(['approved-comments','comments-manager','unapproved-comments'])
    <li class="nav-item has-treeview {{ isActive(['admin.comment.approved','admin.comment.unapproved'],'menu-open') }} ">
        <a href="#" class="nav-link {{ isActive(['admin.comment.approved','admin.comment.unapproved']) }}">
            <i class="nav-icon fa fa-id-card"></i>
            <p>
                نظرات
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @canany(['approved-comments','comments-manager'])
                <li class="nav-item">
                    <a href="{{ route('admin.comment.approved') }}"
                       class="nav-link {{ isActive('admin.comment.approved') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>نظرات تایید شده</p>
                    </a>
                </li>
            @endcanany
            @canany(['unapproved-comments','comments-manager'])
                <li class="nav-item">
                    <a href="{{ route('admin.comment.unapproved') }}"
                       class="nav-link {{ isActive('admin.comment.unapproved') }}">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>نظرات تایید نشده</p>
                    </a>
                </li>
            @endcanany
        </ul>
    </li>
@endcanany
