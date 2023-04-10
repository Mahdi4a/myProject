<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Permission;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PermissionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Permission',
        'description' => 'Permission type',
        'model' => Permission::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the permission'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the permission'
            ],
            'label' => [
                'type' => Type::string(),
                'description' => 'The label the permission'
            ]
        ];
    }
}
