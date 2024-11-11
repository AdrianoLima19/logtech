<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function show()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        /** @var App\Models\User $user */
        $user = Auth::user();
        $user->update($request->only(['name']));

        return $user;
    }

    public function delete()
    {
        /** @var App\Models\User $user */
        $user = Auth::user();
        $user->delete();

        return response()->noContent();
    }

    public function index()
    {
        return User::paginate();
    }

    public function search($id)
    {
        $user = User::find($id);
        $user->makeVisible(['is_admin']);
        return response()->json($user);
    }

    public function change(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only(['name', 'email', 'is_admin']));
        $user->makeVisible(['is_admin']);
        return $user;
    }

    public function remove($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->noContent();
    }
}
