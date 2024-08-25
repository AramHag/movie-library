<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Attempt to log in a user with the given credentials
    public function login(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return [
                'status' => 'error',
                'message' => 'Unauthorized',
                'code' => 401,
            ];
        }

        return [
            'status' => 'success',
            'user' => Auth::user(),
            'token' => $token,
            'code' => 200,
        ];
    }




    // Register new user with the given data
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = Auth::login($user);

        return [
            'status' => 'success',
            'message' => 'User Created Successfully',
            'user' => $user,
            'token' => $token,
            'code' => 201,
        ];
    }

    public function logout()
    {
        Auth::logout();

        return [
            'status' => 'success',
            'message' => 'Successfully Logged Out',
            'code' => 200,
        ];
    }
}


?>