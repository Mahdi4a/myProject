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

class CategoriesQuery extends Query
{
    protected $attributes = [
        'name' => 'Categories',
        'description' => 'get categories with id or name or description or slug or title or part_id or part_type or status'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Category');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the category'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the category'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The slug of the category'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the category'
            ],
            'category_id' => [
                'type' => Type::string(),
                'description' => 'The category_id of the category'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the category'
            ],
//            'part_id' => [
//                'type' => Type::string(),
//                'description' => 'The part_id of the category'
//            ],
            'part_type' => [
                'type' => Type::string(),
                'description' => 'The part_type of the category'
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of the category'
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

        $fields = $getSelectFields();
        $categories = Category::query()
            ->with($fields->getRelations())
            ->select($fields->getSelect());
        if (isset($args['title'])) {
            $categories->where('title', 'LIKE', "%{$args['title']}%");
        }
        if (isset($args['name'])) {
            $categories->orWhere('name', 'LIKE', "%{$args['name']}%");
        }
        if (isset($args['slug'])) {
            $categories->orWhere('slug', 'LIKE', "%{$args['slug']}%");
        }
//        if(isset($args['part_id'])){
//            $categories->orWhere('part_id','LIKE',"%{$args['part_id']}%");
//        }
        if (isset($args['part_type'])) {
            $categories->orWhere('part_type', 'LIKE', "%{$args['part_type']}%");
        }
        if (isset($args['description'])) {
            $categories->orWhere('description', 'LIKE', "%{$args['description']}%");
        }
        if (isset($args['status'])) {
            $categories->orWhere('status', 'LIKE', "%{$args['status']}%");
        }
        if (isset($args['category_id'])) {
            $categories->orWhere('category_id', 'LIKE', "%{$args['category_id']}%");
        }
        if (isset($args['id'])) {
            $categories->orWhere('id', $args['id']);
        }
        return $categories->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);

    }
}
