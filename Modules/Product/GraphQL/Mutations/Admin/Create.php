<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Attribute\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Repositories\ProductRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Create extends Mutation
{
    protected $attributes = [
        'name' => 'productCreate',
        'description' => 'create new product'
    ];

    public function args(): array
    {
        return [
            'product' => [
                'description' => 'the product',
                'type' => GraphQL::type('ProductInput'),
            ],
            'category' => [
                'description' => 'the images',
                'type' => GraphQL::type('[ProductCategory!]!'),
            ],
            'images' => [
                'description' => 'the images',
                'type' => GraphQL::type('[ProductImage!]!'),
            ],
            'attributes' => [
                'description' => 'the attributes',
                'type' => GraphQL::type('[ProductAttribute!]!'),
            ],
            'attributesValue' => [
                'description' => 'the attributesValue',
                'type' => GraphQL::type('[ProductAttributeValue!]!'),
            ],

        ];
    }

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $query = Product::query();
        $product = $query->with($with)->select($select)->where('name', $args['product']['name'])->first();

        if (is_null($product)) {
            $args['product']['user_id'] = auth('api')->user()->id;
//            $repository = new ProductRepository();
//            $repository->createNewProduct();
            $product = $query->create($args['product']);
            if (isset($args['images'])) {
                $array = [];
                foreach ($args['images'] as $image) {
                    $array[] = ['address' => $image['address'], 'imageAble_type' => get_class($product), 'imageAble_id' => $product->id, 'created_at' => now(), 'updated_at' => now(),];
                }
                $product->images()->insert($array);
            }
            $product->categories()->sync($args['category']);


            if (isset($args['attributes'])) {
                foreach ($args['attributes'] as $key => $item) {
                    $attribute = Attribute::query()->firstOrCreate($item);
                    $value = $attribute->values()->create([
                        'value' => $args['attributesValue'][$key]['value'],
                    ]);
                    $value->update([
                        'price' => $args['attributesValue'][$key]['price'],
                        'discount' => $args['attributesValue'][$key]['discount'],
                        'inventory' => $args['attributesValue'][$key]['inventory'],
                    ]);

                    $product->attributes()->attach($attribute->id, ['value_id' => $value->id]);
                }
            }


        }
        $product->load('attributes');

        return $product;
    }
}
