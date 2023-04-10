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

class UpdatePermission extends Mutation
{
    protected $attributes = [
        'name' => 'UpdatePermission',
    ];

    public function type(): Type
    {
        return GraphQL::type('Permission');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'id of user',
                'rules' => ['required', 'exists:permissions,id']
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'name of role',
                'rules' => []
            ],
            'label' => [
                'type' => Type::string(),
                'description' => 'label of role',
                'rules' => ['required'],
            ],
        ];
    }


    protected function rules(array $args = []): array
    {
        $rules = [];
        $rules['name'] = ['required', Rule::unique('permissions', 'name')->ignore($args['id'])];
        return $rules;
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $permission = Permission::query()->where('id', $args['id'])->firstOrFail();
        $permission->update($args);
        return $permission;
    }
}
