<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Permission;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PermissionQuery extends Query
{
    protected $attributes = [
        'name' => 'Permission',
        'description' => 'get permission by id'
    ];

    public function type(): Type
    {
        return GraphQL::type('Permission');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required', 'exists:permissions,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Permission::query()->select($select)->where('id', $args['id'])->with($with)->first();
        }

        return false;
    }
}
