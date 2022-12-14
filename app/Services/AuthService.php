<?php

namespace App\Services;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    /**
     * @throws HttpException
     */
    public function loginUser(array $authId, string $password): User
    {
        $user = User::where($authId)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new HttpException(401, '권한이 없습니다.');
        }

        return $user;
    }

    public function logout(User $user): void
    {
        $user->tokens()->each(function (PersonalAccessToken $token) use ($user) {
            if ($user->currentAccessToken() === $token) {
                $token->delete();
            }
        });
    }

    public function createToken(User $user): string
    {
        return $user->createToken('token-name')->plainTextToken;
    }

    public function join(array $joinUserData): User
    {
        return User::create($joinUserData);
    }

    public function checkUserPassword(string $password): void
    {
        $user = Auth::user();

        if (!Hash::check($password, $user->password)) {
            throw new UnauthorizedHttpException(null, '비밀번호가 다릅니다.');
        }
    }

    public function withdrawUserAccount(User $user): void
    {
        $user->update([
            'email' => "{$user->id}|{$user->email}",
            'mobile_invalid_at' => now(),
            'deleted_at' => now(),
        ]);
    }
}
