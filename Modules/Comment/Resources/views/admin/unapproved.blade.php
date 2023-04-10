@component('main::admin.layouts.content',['title' => 'لیست نظرات تایید نشده'])

    @slot('breadcrumb')
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">خانه</a></li>
        <li class="breadcrumb-item">لیست نظرات تایید نشده</li>
    @endslot
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">نظرات تایید نشده</h3>

            <div class="card-tools d-flex">

                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" value="{{request('search')}}" class="form-control float-right"
                               placeholder="جستجو">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>آی دی نظر</th>
                    <th>نام</th>
                    <th>نظر</th>
                    <th>اقدامات</th>
                </tr>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->user->name}}</td>
                        <td>{{$comment->comment}}</td>
                        <td class="d-flex">
                            @can('delete-comment')
                                <form action="{{ route('admin.comment.destroy' , $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endcan
                            @can('edit-comment')
                                <form action="{{ route('admin.comment.update' , $comment->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-info">تغییر وضعیت</button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{$comments->appends(['search'=> request('search')])->render()}}
        </div>
    </div>

@endcomponent
