<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Role;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class RoleQuery extends Query
{
    protected $attributes = [
        'name' => 'Role',
        'description' => 'get role by id'
    ];

    public function type(): Type
    {
        return GraphQL::type('Role');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required', 'exists:roles,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Role::query()
                ->with($with)
                ->select($select)
                ->where('id', $args['id'])
                ->first();
        }

        return false;
    }
}
