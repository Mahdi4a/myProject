<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Role;
use Rebing\GraphQL\Support\Mutation;

class DeleteRole extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteRole',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'id of role',
                'rules' => ['required', 'exists:roles,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Role::query()->findOrFail($args['id'])?->delete();
    }
}
