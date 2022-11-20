<?php

namespace Modules\User\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\Role;
use Modules\User\Entities\User;

//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function usersWithPaginate()
    {
        $users = $this->model->query();
        if($keyword = request('search')){
            $users->where('email','LIKE',"%{$keyword}%")
                ->orWhere('name','LIKE',"%{$keyword}%")
                ->orWhere('id',$keyword);
        }
        if(request('admin')){
            $users->where('is_superuser',1)->orWhere('is_staff',1);
        }
        return $users->latest()->paginate(20);

    }

    public function createNewUser($request)
    {
        $user = $this->model->query()->create([
           'name'=> $request->name,
           'email'=> $request->email,
           'password'=> $request->password,
        ]);

        $this->verifyEmail($request, $user);
        alert()->success('کاربر مورد نظر با موفقیت ایجاد شد');

        return redirect(route('admin.users.index'));
    }

    public function updateUser($request,$user)
    {
        $data = [
            'name'=> $request->name,
            'email'=> $request->email,
        ];
        if(! is_null($request->password)){
            $data['password'] = $request->password;
        }
        $user->update($data);

        $this->verifyEmail($request, $user);
        alert()->success('کاربر مورد نظر با موفقیت ویرایش شد');

        return redirect(route('admin.users.index'));
    }

    /**
     * @param $request
     * @param $user
     * @return void
     */
    public function verifyEmail($request, $user): void
    {
        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }
    }

    public function permissionCreate($user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('user::admin.permissions', compact('user', 'roles', 'permissions'));

    }


}
