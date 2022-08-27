<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleCreateRequest;
use App\Http\Requests\Admin\Role\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Admin\Role\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;
    public function __construct(RoleRepository $repository)
    {
        $this->roleRepository = $repository;
        $this->middleware('can:show-roles')->only(['index']);
        $this->middleware('can:create-role')->only(['create','store']);
        $this->middleware('can:edit-role')->only(['edit','update']);
        $this->middleware('can:delete-role')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->rolesWithPaginate();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        return $this->roleRepository->createNewRole($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleUpdateRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        return $this->roleRepository->updateRole($request,$role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        alert()->success('کاربر مورد نظر با موفقیت حذف شد');
        return back();
    }
}
