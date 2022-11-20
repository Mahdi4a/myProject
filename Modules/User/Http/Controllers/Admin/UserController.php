<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserCreateRequest;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Http\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
        $this->middleware('can:show-users')->only(['index']);
        $this->middleware('can:create-user')->only(['create', 'store']);
        $this->middleware('can:edit-user')->only(['edit', 'update']);
        $this->middleware('can:delete-user')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = $this->userRepository->usersWithPaginate();
        return view('user::admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        return $this->userRepository->createNewUser($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user::admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        return $this->userRepository->updateUser($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        alert()->success('کاربر مورد نظر با موفقیت حذف شد');
        return back();
    }
}
