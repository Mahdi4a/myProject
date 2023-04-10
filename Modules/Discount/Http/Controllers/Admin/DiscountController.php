<?php

namespace Modules\Discount\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Discount\Entities\Discount;
use Modules\Discount\Http\Requests\StoreRequest;
use Modules\Discount\Http\Requests\UpdateRequest;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $discounts = Discount::query()->latest()->paginate(30);
        return view('discount::admin.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        return view('discount::admin.create', compact('users', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request)
    {
        $discount = Discount::query()->create([
            'code' => $request->code,
            'percent' => $request->percent,
            'expired_at' => now()->addDays(7), // $request->expired_at
        ]);

        $discount->products()->attach($request->products);
        $discount->categories()->attach($request->categories);
        $discount->users()->attach($request->users);

        return redirect(route('admin.discount.index'));
    }

    /**
     * Show the specified resource.
     * @param Discount $discount
     * @return Renderable
     */
    public function show(Discount $discount)
    {
        return view('discount::admin.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Discount $discount
     * @return Renderable
     */
    public function edit(Discount $discount)
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        return view('discount::admin.edit', compact('discount', 'users', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Discount $discount
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Discount $discount)
    {
        $discount->update([
            'code' => $request->code,
            'percent' => $request->percent,
            'expired_at' => $request->expired_at,
        ]);

        $discount->products()->sync($request->products);
        $discount->categories()->sync($request->categories);
        $discount->users()->sync($request->users);
        return redirect(route('admin.discount.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Discount $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        alert()->success('');
        return back();
    }
}
