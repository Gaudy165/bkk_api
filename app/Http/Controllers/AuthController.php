<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Register user baru (HANYA untuk role 'user')
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Upload photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // FORCE role
        $data['role'] = 'user';

        $user = User::create($data);

        // Buat token untuk auto-login setelah register
        $tokenName = $user->role . '_token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $this->userPayload($user),
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Login untuk ADMIN & USER
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        // Cek kredensial
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Ambil user setelah berhasil login
        $user = User::where('email', $request->email)->first();

        $device = $request->input('device_name', 'unknown-device');
        $tokenName = "{$user->role}:{$device}";
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $this->userPayload($user),
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout (hapus token)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Get data user yang sedang login
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => $this->userPayload($user),
        ]);
    }

    private function userPayload(?User $user): ?array
    {
        if (!$user) {
            return null;
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo ? Storage::url($user->photo) : null,
            'role' => $user->role,
        ];
    }
}
