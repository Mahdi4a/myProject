<?php

declare(strict_types=1);

namespace Modules\Product\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class Product extends InputType
{
    protected $attributes = [
        'name' => 'ProductInput',
        'description' => 'Product input',
    ];

    public function fields(): array
    {
        return [
            'title' => [
                'description' => 'the title of product',
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'name' => [
                'description' => 'the name of product',
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'description' => [
                'description' => 'the description of product',
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'seo_description' => [
                'description' => 'the seo_description of product',
                'type' => Type::string(),
                'rules' => ['required']
            ],
        ];
    }
}
