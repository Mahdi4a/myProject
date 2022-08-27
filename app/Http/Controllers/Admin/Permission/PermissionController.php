<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\PermissionCreateRequest;
use App\Http\Requests\Admin\Permission\PermissionUpdateRequest;
use App\Models\Permission;
use App\Repositories\Admin\Permission\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;
    public function __construct(PermissionRepository $repository)
    {
        $this->permissionRepository = $repository;
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:create-permission')->only(['create','store']);
        $this->middleware('can:edit-permission')->only(['edit','update']);
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
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PermissionCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        return $this->permissionRepository->createNewPermission($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PermissionUpdateRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        return $this->permissionRepository->updatePermission($request,$permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        alert()->success('کاربر مورد نظر با موفقیت حذف شد');
        return back();
    }
}
