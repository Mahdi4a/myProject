<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\PermissionCreateRequest;
use Modules\User\Http\Repositories\UserRepository;

class UserPermissionController extends Controller
{
    public function __construct(protected UserRepository $UserRepository)
    {
        $this->middleware('can:create-user-permissions')->only(['create', 'store']);
    }

    public function create(User $user)
    {
        return $this->UserRepository->permissionCreate($user);
    }

    public function store(PermissionCreateRequest $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
        alert()->success('تغییرات با موفقیت اعمال شد');
        return redirect(route('admin.users.index'));
    }
}
