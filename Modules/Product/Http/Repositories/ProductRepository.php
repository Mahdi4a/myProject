<?php

namespace Modules\Product\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Product\Entities\Product;

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
        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhereHas('attributes', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%")
                        ->orWhereHas('values', function ($q) use ($keyword) {
                            $q->where('value', 'LIKE', "%{$keyword}%")
                                ->orWhere('price', 'LIKE', "%{$keyword}%")
                                ->orWhere('discount', 'LIKE', "%{$keyword}%")
                                ->orWhere('inventory', $keyword);
                        });
                })
                ->orWhereHas('categories', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhere('id', $keyword);
        }
        $products = $products->latest()->paginate(20);
        $products->getCollection()->map(fn($q) => $q->category = $q->categories()->pluck('name')->implode(' | '));
        return $products;

    }

    public function createNewProduct($request)
    {
        $product = $this->model->query()->create([
            'title' => $request->title,
            'name' => $request->name,
            'seo_description' => $request->seo_description,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);
        $this->insertProductImage($request, $product);
        $product->categories()->sync($request->category);
        $this->attachAttributeToProduct($request, $product);

        $this->verifyProduct($request, $product);
    }

    function convert2english($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        return str_replace(array(...$persianDecimal, ...$arabicDecimal, ...$arabic, ...$persian), array(...$newNumbers, ...$newNumbers, ...$newNumbers, ...$newNumbers), $string);
    }

    public function updateProduct($request, $product)
    {
        $update = $product->update([
            'title' => $request->title,
            'name' => $request->name,
            'seo_description' => $request->seo_description,
            'description' => $this->convert2english($request->description),
            'user_id_updated' => $request->user()->id,
        ]);
        $product->images()->delete();
        $this->insertProductImage($request, $product);
        $product->categories()->sync($request->category);
        $product->attributes()->detach();
        $this->attachAttributeToProduct($request, $product);
        $this->verifyProduct($request, $product);
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

    public function getProductsForClient($request)
    {
        $products = $this->model->query()->with(['attributes' => function ($query) {
            $query->whereHas('values', function ($query) {
                $query->where('inventory', '>', 0);
            });
        }])->where('status', 1)->latest()->paginate(12);
        $products->getCollection()->transform(function ($item) {
            $item->addRelationToProduct();
            return $item;
        });
        return $products;
    }

    public function getSingleProduct($product)
    {
        $product->addRelationToProduct();
        $product->attributes = $product->attributes->unique();
        return $product;
//        return $this->model->query()->where('slug',$request->id)->firstOrFail();
    }

    /**
     * @param $request
     * @param $product
     * @return void
     */
    public function attachAttributeToProduct($request, $product): void
    {
        foreach ($request->input('attributes') as $key => $item) {
            $attribute = Attribute::query()->firstOrCreate([
                'name' => $item,
            ]);

            $value = $attribute->values()->create([
                'value' => $request->input('values')[$key],
            ]);
            $value->update([
                'price' => $request->input('price')[$key],
                'discount' => $request->input('discount')[$key],
                'inventory' => $request->input('inventory')[$key],
            ]);
            $product->attributes()->attach($attribute->id, ['value_id' => $value->id]);
        }
    }

    public function getAttributeValue($request)
    {
        return Attribute::query()->with('values')->where('id', $request->data)->first()->values;
    }

    public function getValueDetail($request)
    {
        $value = AttributeValue::query()->find($request->data);
        $value->price_with_discount = $value->price - ($value->discount * $value->price) / 100;
        return $value;
    }

    /**
     * @param $request
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $product
     * @return void
     */
    public function insertProductImage($request, \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $product): void
    {
        $array = [];
        foreach ($request->image as $image) {
            $array[] = ['address' => $image, 'imageAble_type' => get_class($product), 'imageAble_id' => $product->id, 'created_at' => now(), 'updated_at' => now(),];
        }
        $product->images()->insert($array);
    }
}
