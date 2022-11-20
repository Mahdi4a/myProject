<?php

declare(strict_types=1);

namespace Modules\Attribute\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class ProductAttribute extends InputType
{
    protected $attributes = [
        'name' => 'ProductAttribute',
        'description' => 'ProductAttribute input',
    ];

    public function fields(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'A name field',
            ],
        ];
    }
}
