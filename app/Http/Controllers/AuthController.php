<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        
        if(!Auth::attempt($data)){
            return response([
                'message' => 'email or password are wrong'
            ]);
        }else{
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);}
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        User::create([
            'name' => $data['name'],
            'job' => $data['job'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'admin' => $data['admin'],
        ]);
        return response()->json([
            'message' =>'nice' ,
        ]);
    }

    public function logout(Request $request){
    $user = $request->user();
    if (!$user) {
        return response()->json(['message' => 'User not authenticated']);
    }
    $user->currentAccessToken()->delete();
    return response()->json([
        'message' => 'Logged out successfully',
        'user' => $user,
    ]);
}

public function user()
    {
        $user=Auth::user();
        return response()->json($user);
    }

}