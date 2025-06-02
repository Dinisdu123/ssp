<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Actions\Fortify\CreateNewUser;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user) {
                Log::error('User is null after Auth::attempt');
                return response()->json(['error' => 'User not found'], 500);
            }
            Log::info('User class: ' . get_class($user));
            Log::info('User methods: ' . print_r(get_class_methods($user), true));
            if (!method_exists($user, 'createTokenForRole')) {
                Log::error('createTokenForRole method not found on User');
                return response()->json(['error' => 'Method createTokenForRole not found'], 500);
            }
            $token = $user->createTokenForRole()->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_photo_url' => $user->profile_photo_url,
                ],
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        try {
            $user = (new CreateNewUser())->create($request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]));
            $token = $user->createTokenForRole()->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_photo_url' => $user->profile_photo_url,
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Delete all tokens for the user
        return response()->json(['message' => 'Logged out'], 200);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'profile_photo_url' => $user->profile_photo_url,
        ], 200);
    }
}