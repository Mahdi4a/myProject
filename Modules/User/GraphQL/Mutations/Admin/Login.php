<?php

declare(strict_types=1);

namespace Modules\User\GraphQL\Mutations\Admin;


use App\Notifications\ActiveCodeNotification;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Entities\ActiveCode;
use Modules\User\Entities\User;
use Rebing\GraphQL\Support\Mutation;

class Login extends Mutation
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'send code to user for login'
    ];

    public function type(): Type
    {
        return Type::listOf(Type::string());
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
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::query()->where('email', $args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->hasTwoFactorAuthEnabled()) {
            $code = ActiveCode::generateCode($user, $user->phone_number);
            if ($user->two_factor_type === 'sms') {
                $user->notify(new ActiveCodeNotification($code, $user->phone_number));
            }
            if ($user->two_factor_type === 'email') {
                $user->notify($code, $user->email);
            }
            return [
                'code' => $code,
                'ConfirmCode' => true,
            ];
        }
        $user->tokens()->where('name', request()?->header('User-Agent'))->delete();
        return [
            'token' => $user->createToken(request()?->header('User-Agent'))->plainTextToken,
        ];
    }
}
