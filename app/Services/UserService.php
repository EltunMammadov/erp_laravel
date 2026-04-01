<?php

namespace App\Services;

use App\Enums\Role;
use App\Repositories\UserRepositories;
use App\Models\User;

class UserService
{
    public function __construct(
        private UserRepositories $userRepositories
    ){}

    public function createUser(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'role' => $data['role'] ?? Role::Employee,
        ]);
    }

    public function getUserByEmail(string $email)
    {
        return $this->userRepositories->getUserByEmail($email);
    }
}