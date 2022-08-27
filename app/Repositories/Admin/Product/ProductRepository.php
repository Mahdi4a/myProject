<?php

namespace App\Repositories\Admin\Product;

use App\Models\Product;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Product::class;
    }
    public function productsWithPaginate()
    {
        $products = $this->model->query();
        if($keyword = request('search')){
            $products->where('title','LIKE',"%{$keyword}%")
                ->orWhere('price','LIKE',"%{$keyword}%")
                ->orWhere('discount','LIKE',"%{$keyword}%")
                ->orWhere('inventory',$keyword)
                ->orWhereHas('category',function($q) use($keyword){
                    $q->where('name','LIKE',"%{$keyword}%");
                })
                ->orWhere('id',$keyword);
        }
        return $products->latest()->paginate(20);

    }

    public function createNewProduct($request)
    {
        $product = $this->model->query()->create([
            'title'=> $request->title,
            'description'=> $request->description,
            'category_id'=> $request->category,
            'price'=> $request->price,
            'discount'=> $request->discount,
            'inventory'=> $request->inventory,
            'user_id'=> $request->user()->id,
        ]);

        $this->verifyProduct($request, $product);
        alert()->success('محصول مورد نظر با موفقیت ایجاد شد');

        return redirect(route('admin.product.index'));
    }

    public function updateProduct($request,$product)
    {
        $product->update( [
            'title'=> $request->title,
            'description'=> $request->description,
            'category_id'=> $request->category,
            'price'=> $request->price,
            'discount'=> $request->discount,
            'inventory'=> $request->inventory,
            'user_id_updated'=> $request->user()->id,
        ]);

        $this->verifyProduct($request, $product);
        alert()->success('محصول مورد نظر با موفقیت ویرایش شد');

        return redirect(route('admin.product.index'));
    }

    /**
     * @param $request
     * @param $product
     * @return void
     */
    public function verifyProduct($request, $product): void
    {
        if ($request->has('status')) {
            $product->markStatusAsActive();
        }
    }
}
