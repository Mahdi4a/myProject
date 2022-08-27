<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\PermissionCreateRequest;
use App\Models\User;
use App\Repositories\Admin\Users\UserRepository;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    protected $UserRepository;
    public function __construct(UserRepository $UserRepository)
    {
        $this->middleware('can:create-user-permissions')->only(['create','store']);
        $this->UserRepository = $UserRepository;
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
