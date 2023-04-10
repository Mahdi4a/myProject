<?php

declare(strict_types=1);

namespace Modules\Category\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Category\Entities\Category;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Update extends Mutation
{
    protected $attributes = [
        'name' => 'categoryUpdate',
        'description' => 'update category value by getting id'
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => (Type::string()),
                'description' => 'The id of the category',
                'rules' => ['required', 'exists:categories,id']
            ],
            'name' => [
                'type' => (Type::string()),
                'description' => 'The name of the category',
                'rules' => ['required']
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The slug the category',
                'rules' => ['required']
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title the category',
                'rules' => ['required']
            ],
            'category_id' => [
                'type' => Type::string(),
                'description' => 'The category_id the category'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description the category',
                'rules' => ['required']
            ],
            'seo_description' => [
                'type' => Type::string(),
                'description' => 'The seo_description the category',
                'rules' => ['required']
            ],
//            'part_id' => [
//                'type' => Type::string(),
//                'description' => 'The part_id the category'
//            ],
            'part_type' => [
                'type' => Type::string(),
                'description' => 'The part_type the category'
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status the category'
            ]


        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = Category::query()->where('id', $args['id'])->first();
        $user?->update($args);
        return $user;
    }
}
