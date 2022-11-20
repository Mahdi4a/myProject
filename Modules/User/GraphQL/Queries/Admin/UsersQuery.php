<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'search through users in name , id , email'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('user');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
            ],
            'admin' => [
                'name' => 'admin',
                'type' => Type::string(),
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'email' => [
                'name' => 'email',
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
        $users = User::query()
            ->with($fields->getRelations())
            ->select($fields->getSelect());
        if (isset($args['email'])) {
            $users->where('email', 'LIKE', "%{$args['email']}%");
        }
        if (isset($args['name'])) {
            $users->orWhere('name', 'LIKE', "%{$args['name']}%");
        }
        if (isset($args['id'])) {
            $users->orWhere('id', $args['id']);
        }
        if (isset($args['admin'])) {
            $users->where(function ($user) {
                $user->where('is_superuser', 1)->orWhere('is_staff', 1);
            });
        }
        return $users->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
