<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Permission;
use Rebing\GraphQL\Support\Mutation;

class DeletePermission extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePermission',
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
                'description' => 'id of permission',
                'rules' => ['required', 'exists:permissions,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Permission::query()->findOrFail($args['id'])?->delete();
    }
}
