<?php

declare(strict_types=1);

namespace Modules\Attribute\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class ProductAttributeValue extends InputType
{
    protected $attributes = [
        'name' => 'ProductAttributeValue',
        'description' => 'productAttributeValue input',
    ];

    public function fields(): array
    {
        return [
            'value' => [
                'type' => Type::string(),
                'description' => 'A value field',
            ],
            'price' => [
                'type' => Type::string(),
                'description' => 'A price field',
            ],
            'discount' => [
                'type' => Type::string(),
                'description' => 'A discount field',
            ],
            'inventory' => [
                'type' => Type::string(),
                'description' => 'A inventory field',
            ],
        ];
    }
}
