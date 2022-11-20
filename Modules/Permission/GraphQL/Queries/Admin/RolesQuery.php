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

class RolesQuery extends Query
{
    protected $attributes = [
        'name' => 'Roles',
        'description' => 'get roles by id or name or label'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Role');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'label' => [
                'name' => 'label',
                'type' => Type::string(),
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $roles = Role::query()
            ->with($with)
            ->select($select);
        if (isset($args['id'])) {
            $roles->where('id', $args['id']);
        }
        if (isset($args['name'])) {
            $roles->where('name', 'LIKE', '%' . $args['name'] . '%');
        }
        if (isset($args['label'])) {
            $roles->where('label', 'LIKE', '%' . $args['label'] . '%');
        }

        return $roles->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
