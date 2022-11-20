<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Queries\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
//    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
//    {
//            return Auth::id() === $args['id'];
//    }
//
//    public function getAuthorizationMessage(): string
//    {
//        return 'You are not authorized to perform this action';
//    }
    protected $attributes = [
        'name' => 'user',
        'description' => 'get user by id or email'
    ];

    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required_if:email,null', 'exists:users,id']
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required_if:id,null', 'exists:users,email']
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return User::where('id', $args['id'])->with($with)->first();
        }

        if (isset($args['email'])) {
            return User::where('email', "like", "%" . $args['email'] . "%")->first();
        }

        return false;
    }
}
