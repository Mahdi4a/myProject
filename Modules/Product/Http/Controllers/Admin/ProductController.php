<?php

namespace Modules\Product\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Modules\Attribute\Entities\Attribute;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
        $this->middleware('can:show-products')->only(['index']);
        $this->middleware('can:create-product')->only(['create', 'store']);
        $this->middleware('can:edit-product')->only(['edit', 'update']);
        $this->middleware('can:delete-product')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->productsWithPaginate();
        return view('product::admin.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('product::admin.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request): Redirector|RedirectResponse|Application
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image.*' => 'required',
            'attributes.*' => 'required',
            'values.*' => 'required',
            'price.*' => 'required',
            'discount.*' => 'required',
            'inventory.*' => 'required',
        ]);
        $this->productRepository->createNewProduct($request);
        alert()->success('محصول مورد نظر با موفقیت ایجاد شد');
        return redirect(route('admin.product.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('product::admin.edit', compact('product', 'categories', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image.*' => 'required',
            'attributes.*' => 'required',
            'values.*' => 'required',
            'price.*' => 'required',
            'discount.*' => 'required',
            'inventory.*' => 'required',
        ]);
        $this->productRepository->updateProduct($request, $product);
        alert()->success('محصول مورد نظر با موفقیت ویرایش شد');
        return redirect(route('admin.product.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success('محصول مورد نظر با موفقیت حذف شد');
        return back();
    }
}
