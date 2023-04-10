<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Types;

use Modules\Product\Entities\Product;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ProductType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Product',
        'description' => 'product type',
        'model' => Product::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'description' => "the id of product",
                'type' => Type::string(),
            ],
            "title" => [
                'description' => "the title of product",
                'type' => Type::string(),
            ],
            "name" => [
                'description' => "the name of product",
                'type' => Type::string(),
            ],
            "slug" => [
                'description' => "the slug of product",
                'type' => Type::string(),
            ],
            "description" => [
                'description' => "the description of product",
                'type' => Type::string(),
            ],
            "status" => [
                'description' => "the status of product",
                'type' => Type::string(),
            ],
            "view_count" => [
                'description' => "the view_count of product",
                'type' => Type::string(),
            ],
            "user_id" => [
                'description' => "the user_id of product",
                'type' => Type::string(),
            ],
            "seo_description" => [
                'description' => "the seo_description of product",
                'type' => Type::string(),
            ],
            'categories' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Category'))),
                'description' => 'The image of product',
                'query' => function (array $args, $query, $ctx): void {
                    $query->addSelect(['categories.id', 'categories.name', 'categories.slug', 'categories.category_id', 'categories.title', 'categories.description', 'categories.seo_description', 'categories.part_type', 'categories.status']);
                }
            ],
            'images' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Image'))),
                'description' => 'The image of product',
                'query' => function (array $args, $query, $ctx): void {
                    $query->addSelect(['address']);
                }
            ],
            'attributes' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Attribute'))),
                'description' => 'The image of product',
                'query' => function (array $args, $query, $ctx): void {
                    $query->addSelect(['name']);
                }
            ],
        ];
    }
}
