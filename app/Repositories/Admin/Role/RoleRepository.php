<?php

namespace App\Repositories\Admin\Role;

use App\Models\Role;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class RoleRepository.
 */
class RoleRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Role::class;
    }

    public function rolesWithPaginate()
    {
        $roles = $this->model->query();
        if($keyword = request('search')){
            $roles->where('label','LIKE',"%{$keyword}%")
                ->orWhere('name','LIKE',"%{$keyword}%");
        }
        return $roles->latest()->paginate(20);
    }

    public function createNewRole($request)
    {
        $role = $this->model->query()->create([
            'name'=> $request->name,
            'label'=> $request->label,
        ]);
        $role->permissions()->sync($request->permissions);
        alert()->success('نقش جدید موفقیت ایجاد شد');
        return redirect(route('admin.roles.index'));
    }

    public function updateRole($request,$role)
    {
        $role->update([
            'name'=> $request->name,
            'label'=> $request->label,
        ]);
        $role->permissions()->sync($request->permissions);
        alert()->success('نقش مورد نظر با موفقیت ویرایش شد');
        return redirect(route('admin.roles.index'));
    }
}
