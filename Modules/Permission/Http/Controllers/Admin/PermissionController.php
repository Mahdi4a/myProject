<?php

namespace Modules\Permission\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Http\Repositories\PermissionRepository;
use Modules\Permission\Http\Requests\PermissionCreateRequest;
use Modules\Permission\Http\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    public function __construct(protected PermissionRepository $permissionRepository)
    {
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:create-permission')->only(['create', 'store']);
        $this->middleware('can:edit-permission')->only(['edit', 'update']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissionRepository->permissionsWithPaginate();
        return view('permission::admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission::admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        return $this->permissionRepository->createNewPermission($request);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permission::admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdateRequest $request
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        return $this->permissionRepository->updatePermission($request, $permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        alert()->success('کاربر مورد نظر با موفقیت حذف شد');
        return back();
    }
}
