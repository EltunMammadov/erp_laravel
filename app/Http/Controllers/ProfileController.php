<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'company_name' => $user->company_name,
                'role' => $user->role->value,
                'avatar_url' => $user->avatar_url,
            ]
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->update($request->only(['first_name', 'last_name', 'phone', 'company_name']));

        return response()->json([
            'success' => true,
            'message' => 'Profil uğurla yeniləndi',
            'data'    => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'company_name' => $user->company_name,
                'role' => $user->role->value,
                'avatar_url' => $user->avatar_url,
            ]
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'avatar.required' => 'Şəkil seçilməyib',
            'avatar.image' => 'Fayl şəkil olmalıdır',
            'avatar.mimes' => 'Yalnız jpg və png formatı qəbul edilir',
            'avatar.max' => 'Şəkil maksimum 2MB ola bilər',
        ]);

        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Avatar uğurla yükləndi',
            'avatar_url' => $user->avatar_url,
        ]);
    }
}
