<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\{
    User,
    LoginLog
};

class AuthService
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    public function createToken(User $user): array
    {
        $expirationMinutes = config('sanctum.expiration');
        $token = $user->createToken(
            date('His'),
            ['*'],
            now()->addMinutes($expirationMinutes)
        );

        return [
            'access_token' => $token->plainTextToken,
            'token_type'   => 'Bearer',
            'expires_in'   => $expirationMinutes * 60,
        ];
    }

    public function attempt(string $password, string $hashed_password): bool
    {
        return Hash::check($password, $hashed_password);
    }

    public function isLocked(User $user): bool
    {
        return $user->locked_until && now()->lt($user->locked_until);
    }

    public function incrementAttempts(User $user): void
    {
        $attempts = $user->login_attempts + 1;

        $user->update([
            'login_attempts' => $attempts,
            'locked_until' => $attempts >= self::MAX_ATTEMPTS
                ? now()->addMinutes(self::LOCK_MINUTES)
                : null
        ]);
    }

    public function log(?User $user, string $email, string $ip, bool $success): void
    {
        LoginLog::create([
            'user_id' => $user?->id,
            'email' => $email,
            'ip_address' => $ip,
            'success' => $success,
            'created_at' => now(),
        ]);
    }

    public function resetAttempts(User $user): void
    {
        $user->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    public function logout(User $user): void
    {
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }
}