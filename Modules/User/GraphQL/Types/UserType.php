<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'user',
        'description' => 'A type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the user',
                // Use 'alias', if the database column is different from the type name.
                // This is supported for discrete values as well as relations.
                // - you can also use `DB::raw()` to solve more complex issues
                // - or a callback returning the value (string or `DB::raw()` result)
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user',
            ],
            'phone_number' => [
                'type' => Type::string(),
                'description' => 'The name of user',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The name of user',
                'resolve' => function ($root, array $args) {
                    // If you want to resolve the field yourself,
                    // it can be done here
                    return ($root) ? jdate($root->created_at)->format('Y-m-d H:i:s') : $root;
                }
            ],
            'permissions' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Permission'))),
                'description' => 'The password of user',
                'query' => function (array $args, $query, $ctx): void {
                    $query->addSelect(['name', 'label']);
                }
            ],
            // Uses the 'getIsMeAttribute' function on our custom User model
            'isMe' => [
                'type' => Type::boolean(),
                'description' => 'True, if the queried user is the current user',
                'selectable' => false, // Does not try to query this from the database
            ]
        ];
    }
}
