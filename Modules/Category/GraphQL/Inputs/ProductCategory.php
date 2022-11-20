<?php

declare(strict_types=1);

namespace Modules\Category\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class ProductCategory extends InputType
{
    protected $attributes = [
        'name' => 'ProductCategory',
        'description' => 'productCategory input',
    ];

    public function fields(): array
    {
        return [
            'category_id' => [
                'type' => Type::string(),
                'description' => 'id field of category',
            ],
        ];
    }
}
