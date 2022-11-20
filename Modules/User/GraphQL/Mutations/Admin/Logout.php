<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class Logout extends Mutation
{
    protected $attributes = [
        'name' => 'Logout',
        'description' => 'logout the current user'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return auth('api')->user()?->tokens()->where('name', request()?->header('User-Agent'))->delete();
    }
}
