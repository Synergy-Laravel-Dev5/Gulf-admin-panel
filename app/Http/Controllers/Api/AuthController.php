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
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8',
            'user_type'    => 'nullable|string|in:client,company',
            'company_name' => 'required_if:user_type,company|nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $otp = rand(100000, 999999);
        $userType = $request->user_type ?? 'client';
        $logoPath = null;

        if ($userType === 'company' && $request->hasFile('logo')) {
            $destinationPath = public_path('uploads/company_logos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('logo');
            $filename = time() . '_logo_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $logoPath = 'uploads/company_logos/' . $filename;
        }

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'status'       => 'active',
            'otp_code'     => $otp,
            'user_type'    => $userType,
            'company_name' => $userType === 'company' ? $request->company_name : null,
            'logo'         => $logoPath,
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
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'user_type'    => $user->user_type,
                'company_name' => $user->company_name,
                'logo_url'     => $user->logo_url,
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User with this email does not exist.'
            ], 404);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Forgot Password OTP Mail failed: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => true,
            'message' => 'A 6-digit verification code has been sent to your email.'
        ]);
    }


    public function resetPassword(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email'    => 'required|email',
            'otp_code' => 'required_without:token|nullable|digits:6',
            'token'    => 'required_without:otp_code|nullable|string',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->filled('otp_code')) {
            $user = User::where('email', $request->email)
                ->where('otp_code', $request->otp_code)
                ->first();

            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid email or verification code.'
                ], 400);
            }

            $user->password = Hash::make($request->password);
            $user->otp_code = null;
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Your password has been reset successfully.'
            ]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
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

        $user->status = 'inactive';
        $user->save();

        $user->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Account deactivated successfully.'
        ]);
    }

    public function googleLogin(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email'           => 'required|email',
            'name'            => 'nullable|string|max:255',
            'google_id'       => 'nullable|string|max:255',
            'profile_picture' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name'              => $request->name ?? strstr($request->email, '@', true),
                'email'             => $request->email,
                'google_id'         => $request->google_id,
                'password'          => Hash::make(\Illuminate\Support\Str::random(16)),
                'status'            => 'active',
                'user_type'         => 'client',
                'profile_picture'   => $request->profile_picture,
                'email_verified_at' => now(),
            ]);
        } else {
            if ($user->status === 'inactive') {
                return response()->json([
                    'status'  => false,
                    'message' => 'Your account is inactive. Please contact admin.'
                ], 403);
            }
            if ($request->filled('google_id')) {
                $user->google_id = $request->google_id;
            }
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('profile_picture') && !$user->profile_picture) {
                $user->profile_picture = $request->profile_picture;
            }
            $user->save();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Google Login Successful',
            'token'   => $token,
            'user'    => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'phone'               => $user->phone,
                'status'              => $user->status,
                'user_type'           => $user->user_type,
                'profile_picture'     => $user->profile_picture,
                'profile_picture_url' => $user->profile_picture_url,
            ]
        ]);
    }
}
