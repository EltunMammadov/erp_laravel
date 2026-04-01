<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\{Hash, DB, Mail};
use Illuminate\Support\Str;

class PasswordService
{
    private const TOKEN_EXPIRES_MINUTES = 60;

    public function sendResetLink(string $email): bool
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return true;
        }

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        Mail::send('emails.password-reset', ['token' => $token, 'email' => $email], function ($message) use ($email) {
            $message->to($email)->subject('Şifrə sıfırlama linki');
        });

        return true;
    }

    public function resetPassword(string $email, string $token, string $newPassword): bool
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return false;
        }

        // Token müddəti keçibmi? (60 dəqiqə)
        $createdAt = \Carbon\Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(self::TOKEN_EXPIRES_MINUTES)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return false;
        }

        // Token düzgündürmü?
        if (!Hash::check($token, $record->token)) {
            return false;
        }

        // Şifrəni yenilə
        User::where('email', $email)->update([
            'password' => Hash::make($newPassword),
        ]);

        // İstifadə edilmiş tokeni sil
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return true;
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return true;
    }
}
