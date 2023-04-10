<?php

namespace Modules\Category\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Category\Entities\Category;

//use Your Model

/**
 * Class CategoryRepository.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Category::class;
    }

    public function categoriesWithPaginate()
    {
        $categories = $this->model->query();
        if($keyword = request('search')){
            $categories->where('name','LIKE',"%{$keyword}%")
                ->orWhereHas('parentCategory',function($q) use($keyword){
                    $q->where('name','LIKE',"%{$keyword}%");
                })
                ->orWhere('id',$keyword);
        }
        return $categories->latest()->paginate(20);

    }

    public function createNewCategory($request)
    {
        $category = $this->model->query()->create([
            'title' => $request->title,
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'seo_description' => $request->seo_description,
            'user_id' => $request->user()->id,
        ]);

        $this->verifyCategory($request, $category);
        alert()->success('دسته بندی مورد نظر با موفقیت ایجاد شد');

        return redirect(route('admin.category.index'));
    }

    public function updateCategory($request,$category)
    {
        $category->update([
            'title' => $request->title,
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'seo_description' => $request->seo_description,
            'user_id_updated' => $request->user()->id,
        ]);

        $this->verifyCategory($request, $category);
        alert()->success('دسته بندی مورد نظر با موفقیت ویرایش شد');

        return redirect(route('admin.category.index'));
    }

    /**
     * @param $request
     * @param $category
     * @return void
     */
    public function verifyCategory($request, $category): void
    {
        if ($request->has('status')) {
            $category->markStatusAsActive();
        }
    }
}
