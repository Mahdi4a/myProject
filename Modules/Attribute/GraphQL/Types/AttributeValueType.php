<?php

declare(strict_types=1);

namespace Modules\Attribute\GraphQL\Types;

use Modules\Attribute\Entities\AttributeValue;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class AttributeValueType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AttributeValue',
        'description' => 'attributeValue type',
        'model' => AttributeValue::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'description' => "the id of attributeValue",
                'type' => Type::string(),
            ],
            "value" => [
                'description' => "the value of attributeValue",
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return object_get($value, 'pivot.value');
                },
            ],
            "price" => [
                'description' => "the price of attributeValue",
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($post) {
                    return object_get($post, 'pivot.price');
                },
            ],
            "discount" => [
                'description' => "the discount of attributeValue",
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($post) {
                    return object_get($post, 'pivot.discount');
                },
            ],
            "inventory" => [
                'description' => "the inventory of attributeValue",
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($post) {
                    return object_get($post, 'pivot.inventory');
                },
            ],
        ];
    }
}
