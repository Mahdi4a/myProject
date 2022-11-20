<?php

declare(strict_types=1);

namespace Modules\Category\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Category\Entities\Category;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class CategoryQuery extends Query
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'get category by id'
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required', 'exists:categories,id']
            ],

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $category = Category::query();
        if (isset($args['id'])) {
            return $category->with($with)->select($select)->where('id', $args['id'])->first();
        }
        return $category;

    }
}
