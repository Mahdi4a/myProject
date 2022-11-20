<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Product\Entities\Product;
use Rebing\GraphQL\Support\Mutation;

class Delete extends Mutation
{
    protected $attributes = [
        'name' => 'ProductDelete',
        'description' => 'delete product'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'id of product',
                'rules' => ['required', 'exists:products,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Product::query()->findOrFail($args['id'])?->delete();
    }
}
