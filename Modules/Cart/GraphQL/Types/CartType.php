<?php

declare(strict_types=1);

namespace Modules\Cart\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;

class CartType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Cart/Cart',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [

        ];
    }
}
