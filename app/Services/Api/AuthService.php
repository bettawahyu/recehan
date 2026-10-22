<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Login user dan menghasilkan Personal Access Token Passport.
     */
    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Cek apakah user aktif
        if (! $user->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => ['Akun Anda tidak aktif.'],
            ]);
        }

        // Buat token Passport
        $token = $user->createToken('Flutter')->accessToken;

        return [
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => $user,
        ];
    }

    /**
     * Mengambil profil user yang sedang login.
     */
    public function profile(User $user): User
    {
        return $user->load('roles');
    }

    /**
     * Logout device saat ini.
     */
    public function logout(User $user): void
    {
        $user->token()->revoke();
    }
}