<?php

declare(strict_types=1);

namespace Modules\Category\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Modules\Category\Entities\Category;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'category type',
        'model' => Category::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the category'
            ],
            'name' => [
                'type' => (Type::string()),
                'description' => 'The name of the category'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The slug of the category'
            ],
            'category_id' => [
                'type' => Type::string(),
                'description' => 'The category_id of the category'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the category'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the category'
            ],
            'seo_description' => [
                'type' => Type::string(),
                'description' => 'The seo_description of the category'
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
            ]

        ];
    }
}
