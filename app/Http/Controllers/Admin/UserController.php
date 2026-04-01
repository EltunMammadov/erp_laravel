<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createUser([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'İstifadəçi uğurla yaradıldı',
            'data'    => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role->value,
                'phone' => $user->phone,
                'company_name' => $user->company_name,
            ]
        ], 201);
    }
}
