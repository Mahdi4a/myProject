<?php

declare(strict_types=1);

namespace Modules\Cart\GraphQL\Mutations\Client;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateCart extends Mutation
{
    protected $attributes = [
        'name' => 'cart/CreateCart',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::listOf(Type::string());
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return [];
    }
}
