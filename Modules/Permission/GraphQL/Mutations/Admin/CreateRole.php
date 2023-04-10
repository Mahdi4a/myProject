<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Modules\Permission\Entities\Role;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateRole extends Mutation
{
    protected $attributes = [
        'name' => 'CreateRole',
    ];

    public function type(): Type
    {
        return GraphQL::type('Role');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => "name of role",
                'rules' => ['required', Rule::unique('roles', 'name')],
            ],
            'label' => [
                'type' => Type::string(),
                'description' => "label of role",
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Role::query();
        $role = $query->whereName($args['name'])->first();
        if (is_null($role)) {
            return $query->create($args);
        }
        return $role;
    }
}
