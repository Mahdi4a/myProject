<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Permission;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PermissionsQuery extends Query
{
    protected $attributes = [
        'name' => 'Permissions',
        'description' => 'get permissions by id or name or label'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Permission');
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
        $permissions = Permission::query()
            ->with($with)
            ->select($select);
        if (isset($args['id'])) {
            $permissions->where('id', $args['id']);
        }
        if (isset($args['name'])) {
            $permissions->where('name', 'LIKE', "%" . $args['name'] . "%");
        }
        if (isset($args['label'])) {
            $permissions->where('label', 'LIKE', "%" . $args['label'] . "%");
        }

        return $permissions->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
