<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
        $this->middleware('can:show-categories')->only(['index']);
        $this->middleware('can:create-category')->only(['create', 'store']);
        $this->middleware('can:edit-category')->only(['edit', 'update']);
        $this->middleware('can:delete-category')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->categoriesWithPaginate();
        return view('category::admin.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('category::admin.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->categoryRepository->createNewCategory($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('category::admin.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        return $this->categoryRepository->updateCategory($request, $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        alert()->success('محصول مورد نظر با موفقیت حذف شد');
        return back();
    }
}
