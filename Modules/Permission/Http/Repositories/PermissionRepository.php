<?php

namespace Modules\Permission\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Permission\Entities\Permission;

//use Your Model

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Permission::class;
    }


    public function permissionsWithPaginate()
    {
        $permissions = $this->model->query();
        if($keyword = request('search')){
            $permissions->where('label','LIKE',"%{$keyword}%")
                ->orWhere('name','LIKE',"%{$keyword}%");
        }
        return $permissions->latest()->paginate(20);
    }

    public function createNewPermission($request)
    {
        $this->model->query()->create([
            'name'=> $request->name,
            'label'=> $request->label,
        ]);
        alert()->success('دسترسی جدید موفقیت ایجاد شد');
        return redirect(route('admin.permissions.index'));
    }

    public function updatePermission($request,$permission)
    {
        $permission->update([
            'name'=> $request->name,
            'label'=> $request->label,
        ]);
        alert()->success('دسترسی مورد نظر با موفقیت ویرایش شد');
        return redirect(route('admin.permissions.index'));
    }
}
