<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Attribute\Entities\Attribute;
use Modules\Product\Entities\Product;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Update extends Mutation
{
    protected $attributes = [
        'name' => 'productUpdate',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'description' => 'id the product',
                'type' => Type::String(),
            ],
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

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $product = Product::query();
        $product = $product->with($with)->select($select)->where('id', $args['id'])->first();

        if (!is_null($product)) {
            $args['product']['user_id_updated'] = auth('api')->user()->id;
//            $repository = new ProductRepository();
//            $repository->createNewProduct();
            $product->update($args['product']);
            if (isset($args['images'])) {
                $product->images()->delete();
                $array = [];
                foreach ($args['images'] as $image) {
                    $array[] = ['address' => $image['address'], 'imageAble_type' => get_class($product), 'imageAble_id' => $product->id, 'created_at' => now(), 'updated_at' => now(),];
                }
                $product->images()->insert($array);
            }
            $product->categories()->sync($args['category']);

            if (isset($args['attributes'])) {
                $product->attributes()->detach();
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
