<?php

declare(strict_types=1);

namespace Modules\Permission\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Modules\Permission\Entities\Role;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RoleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Role',
        'description' => 'Role type',
        'model' => Role::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the role'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the role'
            ],
            'label' => [
                'type' => Type::string(),
                'description' => 'The label the role'
            ]
        ];
    }
}
