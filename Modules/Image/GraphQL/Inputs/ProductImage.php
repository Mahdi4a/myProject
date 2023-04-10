<?php

declare(strict_types=1);

namespace Modules\Image\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class ProductImage extends InputType
{
    protected $attributes = [
        'name' => 'ProductImage',
        'description' => 'productImage input',
    ];

    public function fields(): array
    {
        return [
            'address' => [
                'type' => Type::string(),
                'description' => 'A address field',
            ],
        ];
    }
}
