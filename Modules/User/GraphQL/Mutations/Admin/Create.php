<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Mutations\Admin;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Create extends Mutation
{
    protected $attributes = [
        'name' => 'CreateUser',
    ];

    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => "name of user",
                'rules' => ['required'],
            ],
            'email' => [
                'type' => Type::string(),
                'description' => "email of user",
                'rules' => ['required', 'email', Rule::unique('users', 'email')],
            ],
            'password' => [
                'type' => Type::string(),
                'description' => "password of user",
                'rules' => ['required', 'min:5'],
            ],
            'two_factor_type' => [
                'type' => Type::string(),
                'description' => "two_factor_type of user",
                'rules' => ['nullable', 'in:off,on'],
            ],
            'phone_number' => [
                'type' => Type::string(),
                'description' => "phone_number of user",
                'rules' => ['required', 'string', 'min:10', 'max:11'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = User::query();
        $user = $query->whereEmail($args['email'])->first();
        if (is_null($user)) {
            return $query->create($args);
        }
        return $user;
    }
}
