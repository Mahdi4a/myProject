<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Mutations\Admin;


use App\Notifications\UserLoggedInNotification;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Entities\ActiveCode;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Mutation;

class ConfirmCode extends Mutation
{
    protected $attributes = [
        'name' => 'ConfirmCode',
        'description' => 'Confirm Code and login user'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required', 'exists:users,email']
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'code' => [
                'name' => 'code',
                'type' => Type::string(),
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
//        dd(request()?->header('User-Agent'),$root,  $args, $context,  $resolveInfo,  $getSelectFields);
        $user = User::query()->where('email', $args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if (!ActiveCode::verifyCode($args['code'], $user, $user->phone_number)) {
            throw ValidationException::withMessages([
                'email' => ['کد وارد شده اشتباه است'],
            ]);
        }
        $user->notify(new UserLoggedInNotification());
        $user->tokens()->where('name', request()?->header('User-Agent'))->delete();
        return $user->createToken(request()?->header('User-Agent'))->plainTextToken;
    }
}
