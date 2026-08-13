<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => 'active',
            'otp_code' => $otp,
        ]);

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Mail dispatch failed: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => true,
            'message' => 'User Registered Successfully. A 6-digit verification code has been sent to your email.',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ], 201);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp_code' => 'required|string|min:6|max:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or verification code.'
            ], 422);
        }

        $user->otp_code = null;
        $user->email_verified_at = now();
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Email verified successfully. Login complete.',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found.'
            ], 404);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Resend Mail failed: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => true,
            'message' => 'A new verification code has been sent to your email.'
        ]);
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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }


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

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => __($status)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => __($status)
        ], 400);
    }

    public function deactivateAccount(Request $request)
    {
        $user = $request->user();

        // Mark user status as inactive
        $user->status = 'inactive';
        $user->save();

        // Revoke all Sanctum tokens
        $user->tokens()->delete();

        // Soft delete the user account
        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Account deactivated and deleted successfully.'
        ]);
    }
}
