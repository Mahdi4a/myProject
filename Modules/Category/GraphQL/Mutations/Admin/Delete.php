<?php

declare(strict_types=1);

namespace Modules\Category\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Category\Entities\Category;
use Rebing\GraphQL\Support\Mutation;

class Delete extends Mutation
{
    protected $attributes = [
        'name' => 'categoryDelete',
        'description' => 'deleting category by getting id'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => (Type::string()),
                'description' => 'The id of the category',
                'rules' => ['required', 'exists:categories,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Category::query()->where('id', $args['id'])->first()?->delete();
    }
}
