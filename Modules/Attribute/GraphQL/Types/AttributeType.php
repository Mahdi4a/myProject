<?php

declare(strict_types=1);

namespace Modules\Attribute\GraphQL\Types;

use Modules\Attribute\Entities\Attribute;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AttributeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Attribute',
        'description' => 'attribute type',
        'model' => Attribute::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'description' => "the id of attribute",
                'type' => Type::string(),
            ],
            "name" => [
                'description' => "the name of attribute",
                'type' => Type::string(),
            ],
            'value_id' => [
                'description' => 'the value of attributeValue',
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return $value->pivot->value->id;
                },
            ],
            'value' => [
                'description' => 'the value of attributeValue',
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return $value->pivot->value->value;
                },
            ],
            'price' => [
                'description' => 'the price of attributeValue',
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return $value->pivot->value->price;
                },
            ],
            'discount' => [
                'description' => 'the discount of attributeValue',
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return $value->pivot->value->discount;
                },
            ],
            'inventory' => [
                'description' => 'the inventory of attributeValue',
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function ($value) {
                    return $value->pivot->value->inventory;
                },
            ],
        ];
    }
}
