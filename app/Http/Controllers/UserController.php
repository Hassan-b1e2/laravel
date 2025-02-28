<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function show(User $User)
    {    
        return response()->json($User);
    
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'phone' => 'required|string|max:20',
            'admin' => 'boolean',
        ]);
    
        User::create([
            'name' => $data['name'],
            'job' => $data['job'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'admin' => $data['admin'],
        ]);
    }


    public function update(User $User,Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'admin' => 'required|boolean',
            'password' => 'required',
            'job' => 'required'
        ]);
    
        $User->update([
            'name' => $data['name'],
            'job' => $data['job'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'admin' => $data['admin'],
        ]);
        return response()->json($User);

    }

    public function destroy(User $User)
    {
        $User->delete();
        return response()->json(null, 204);
    }
}
