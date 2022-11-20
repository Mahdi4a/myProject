<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Modules\Permission\Entities\Permission;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreatePermission extends Mutation
{
    protected $attributes = [
        'name' => 'CreatePermission',
    ];

    public function type(): Type
    {
        return GraphQL::type('Permission');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'name of role',
                'rules' => ['required', Rule::unique('permissions', 'name')],
            ],
            'label' => [
                'type' => Type::string(),
                'description' => 'label of role',
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Permission::query();
        $permission = $query->whereName($args['name'])->first();
        if (is_null($permission)) {
            return $query->create($args);
        }
        return $permission;
    }
}
