<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\{
    RegisterRequest,
    LoginRequest,
    ForgotPasswordRequest,
    ResetPasswordRequest,
    ChangePasswordRequest
};
use App\Http\Controllers\Controller;
use App\Services\{
    UserService,
    AuthService,
    PasswordService
};
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private UserService $userService,
        private AuthService $authService,
        private PasswordService $passwordService
    ) {}

    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->userService->createUser([
            'first_name' => $registerRequest->first_name,
            'last_name' => $registerRequest->last_name,
            'email' => $registerRequest->email,
            'password' => $registerRequest->password,
            'phone' => $registerRequest->phone,
            'company_name' => $registerRequest->company_name
        ]);

        $token = $this->authService->createToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Qeydiyyat uğurla tamamlandı',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'company_name' => $user->company_name
                ],
                ...$token
            ]
        ], 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        $email = $loginRequest->email;
        $ip = $loginRequest->ip();

        $user = $this->userService->getUserByEmail($email);
        if (!$user) {
            $this->authService->log(null, $email, $ip, false);
            return response()->json([
                'success' => false,
                'message' => 'E-poçt ünvanı və ya şifr yanlışdır'
            ], 400);
        }

        if ($this->authService->isLocked($user)) {
            $this->authService->log($user, $email, $ip, false);
            $minutesLeft = (int) now()->diffInMinutes($user->locked_until, false);
            return response()->json([
                'success' => false,
                'message' => "Hesab müvəqqəti kilidlənib. {$minutesLeft} dəqiqə sonra yenidən cəhd edin."
            ], 429);
        }

        if (!$this->authService->attempt($loginRequest->password, $user->password)) {
            $this->authService->incrementAttempts($user);
            $this->authService->log($user, $email, $ip, false);
            return response()->json([
                'success' => false,
                'message' => 'E-poçt ünvanı və ya şifr yanlışdır'
            ], 400);
        }

        $this->authService->resetAttempts($user);
        $this->authService->log($user, $email, $ip, true);
        $token = $this->authService->createToken($user);

        return response()->json([
            'success' => true,
            'message' => 'Giriş uğurla həyata keçirildi',
            'data' => $token
        ]);
    }
    
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Çıxış uğurla həyata keçirildi'
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->passwordService->sendResetLink($request->email);

        return response()->json([
            'success' => true,
            'message' => 'Şifrə sıfırlama linki e-poçt ünvanınıza göndərildi'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->passwordService->resetPassword(
            $request->email,
            $request->token,
            $request->password
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Token yanlış və ya müddəti bitib'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Şifr uğurla yeniləndi'
        ]);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $result = $this->passwordService->changePassword(
            $request->user(),
            $request->current_password,
            $request->new_password
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Cari şifr yanlışdır'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Şifr uğurla dəyişdirildi'
        ]);
    }
}
