<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => "string|email|max:255|unique:users,email,{$user->id}",
            'password' => 'string|min:8|max:20',
            'phone' => 'nullable|string|max:15',
        ]);

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
        ]);

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
