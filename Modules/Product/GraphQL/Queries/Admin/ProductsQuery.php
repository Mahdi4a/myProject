<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Product\Entities\Product;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class ProductsQuery extends Query
{
    protected $attributes = [
        'name' => 'Products',
        'description' => 'paginate products with search'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
            ],
            'title' => [
                'description' => 'the title of product',
                'type' => Type::string(),
            ],
            'name' => [
                'description' => 'the name of product',
                'type' => Type::string(),
            ],
            'slug' => [
                'description' => 'the slug of product',
                'type' => Type::string(),
            ],
            'description' => [
                'description' => 'the description of product',
                'type' => Type::string(),
            ],
            'status' => [
                'description' => 'the status of product',
                'type' => Type::string(),
            ],
            'view_count' => [
                'description' => 'the view_count of product',
                'type' => Type::string(),
            ],
            'user_id' => [
                'description' => 'the user_id of product',
                'type' => Type::string(),
            ],
            'seo_description' => [
                'description' => 'the seo_description of product',
                'type' => Type::string(),
            ],
            'attributesName' => [
                'description' => 'the attributesName',
                'type' => Type::string(),
            ],
            'attributesValue' => [
                'description' => 'the attributesValue',
                'type' => Type::string(),
            ],
            'attributesValuePrice' => [
                'description' => 'the attributesValuePrice',
                'type' => Type::string(),
            ],
            'attributesValueInventory' => [
                'description' => 'the attributesValueInventory',
                'type' => Type::string(),
            ],
            'attributesValueDiscount' => [
                'description' => 'the attributesValueDiscount',
                'type' => Type::string(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $products = Product::query()
            ->with($with)
            ->select($select);

        if (isset($args['id'])) {
            $products->where('id', $args['id']);
        }
        if (isset($args['title'])) {
            $products->OrWhere('title', 'LIKE', "%{$args['title']}%");
        }
        if (isset($args['name'])) {
            $products->orWhere('name', 'LIKE', "%{$args['name']}%");
        }
        if (isset($args['slug'])) {
            $products->orWhere('slug', 'LIKE', "%{$args['slug']}%");
        }
        if (isset($args['description'])) {
            $products->orWhere('description', 'LIKE', "%{$args['description']}%");
        }
        if (isset($args['status'])) {
            $products->orWhere('status', 'LIKE', "%{$args['status']}%");
        }
        if (isset($args['view_count'])) {
            $products->orWhere('view_count', 'LIKE', "%{$args['view_count']}%");
        }
        if (isset($args['user_id'])) {
            $products->orWhere('user_id', 'LIKE', "%{$args['user_id']}%");
        }
        if (isset($args['seo_description'])) {
            $products->orWhere('seo_description', 'LIKE', "%{$args['seo_description']}%");
        }
        if (isset($args['attributesName'])) {
            $products->orHas('attributes', function ($query) use ($args) {
                $query->where('name', 'LIKE', "%{$args['attributesName']}%");
            });
        }
        if (isset($args['attributesValue']) || isset($args['attributesValuePrice']) || isset($args['attributesValueInventory']) || isset($args['attributesValueDiscount'])) {

            $products->orHas('attributes', function ($query) use ($args) {
                $query->has('values', function ($q) use ($args) {
                    $q->orWhere('value', 'LIKE', "%{$args['attributesValue']}%");
                    $q->orWhere('price', 'LIKE', "%{$args['attributesValuePrice']}%");
                    $q->orWhere('inventory', 'LIKE', "%{$args['attributesValueInventory']}%");
                    $q->orWhere('discount', 'LIKE', "%{$args['attributesValueDiscount']}%");
                });
            });
        }
        return $products->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
