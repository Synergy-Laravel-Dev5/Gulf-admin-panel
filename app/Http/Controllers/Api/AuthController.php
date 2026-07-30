<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => 'active',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'User Registered Successfully',
            'token'   => $token,
            'user'    => $user
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);


        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json([
                'status'  => false,
                'message' => 'Invalid Email or Password'
            ], 401);
        }


        $user = Auth::user();


        if ($user->status === 'inactive') {

            Auth::logout();

            return response()->json([
                'status'  => false,
                'message' => 'Your account is inactive. Please contact admin.'
            ], 403);
        }


        $token = $user->createToken('api_token')->plainTextToken;


        return response()->json([
            'status'  => true,
            'message' => 'Login Successful',
            'token'   => $token,
            'user'    => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'status' => $user->status,
            ]
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logout Successfully'
        ]);
    }


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );


        return response()->json([
            'status' => true,
            'message' => __($status)
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);


        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );


        return response()->json([
            'status' => true,
            'message' => __($status)
        ]);
    }
}
