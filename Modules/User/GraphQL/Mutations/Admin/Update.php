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

class Update extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUser',
    ];

    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'id of user',
                'rules' => ['required', 'exists:users,id']
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'name of user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'email of user',
                'rules' => [],
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'password of user'
            ],
            'two_factor_type' => [
                'type' => Type::string(),
                'description' => 'two_factor_type of user'
            ],
            'phone_number' => [
                'type' => Type::string(),
                'description' => 'phone_number of user'
            ],
        ];
    }


    protected function rules(array $args = []): array
    {
        $rules = [];
        $rules['email'] = ['required', 'email', Rule::unique('users', 'email')->ignore($args['id'])];
        return $rules;
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::query()->where('id', $args['id'])->firstOrFail();
        $user->update($args);
        return $user;
    }
}
