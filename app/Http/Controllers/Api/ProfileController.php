<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Get authenticated user profile with document URLs.
     */
    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'data' => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'phone'               => $user->phone,
                'status'              => $user->status,
                'role'                => $user->role,
                'profile_picture'     => $user->profile_picture,
                'profile_picture_url' => $user->profile_picture_url,
                'passport'            => $user->passport,
                'passport_url'        => $user->passport_url,
                'cnic'                => $user->cnic,
                'cnic_url'            => $user->cnic_url,
                'visa'                => $user->visa,
                'visa_url'            => $user->visa_url,
                'ticket'              => $user->ticket,
                'ticket_url'          => $user->ticket_url,
                'created_at'          => $user->created_at,
                'updated_at'          => $user->updated_at,
            ]
        ]);
    }

    /**
     * Update user profile information and upload documents (Profile Picture, Passport, CNIC, Visa, Ticket).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'            => 'nullable|string|max:255',
            'phone'           => 'nullable|string|max:30',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'passport'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'visa'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'ticket'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        // Upload Profile Picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Upload Passport Document
        if ($request->hasFile('passport')) {
            if ($user->passport && Storage::disk('public')->exists($user->passport)) {
                Storage::disk('public')->delete($user->passport);
            }
            $user->passport = $request->file('passport')->store('user_documents/passports', 'public');
        }

        // Upload CNIC Document
        if ($request->hasFile('cnic')) {
            if ($user->cnic && Storage::disk('public')->exists($user->cnic)) {
                Storage::disk('public')->delete($user->cnic);
            }
            $user->cnic = $request->file('cnic')->store('user_documents/cnics', 'public');
        }

        // Upload Visa Document
        if ($request->hasFile('visa')) {
            if ($user->visa && Storage::disk('public')->exists($user->visa)) {
                Storage::disk('public')->delete($user->visa);
            }
            $user->visa = $request->file('visa')->store('user_documents/visas', 'public');
        }

        // Upload Ticket Document
        if ($request->hasFile('ticket')) {
            if ($user->ticket && Storage::disk('public')->exists($user->ticket)) {
                Storage::disk('public')->delete($user->ticket);
            }
            $user->ticket = $request->file('ticket')->store('user_documents/tickets', 'public');
        }

        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'data'    => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'phone'               => $user->phone,
                'status'              => $user->status,
                'role'                => $user->role,
                'profile_picture'     => $user->profile_picture,
                'profile_picture_url' => $user->profile_picture_url,
                'passport'            => $user->passport,
                'passport_url'        => $user->passport_url,
                'cnic'                => $user->cnic,
                'cnic_url'            => $user->cnic_url,
                'visa'                => $user->visa,
                'visa_url'            => $user->visa_url,
                'ticket'              => $user->ticket,
                'ticket_url'          => $user->ticket_url,
            ]
        ]);
    }

    /**
     * Dedicated document upload endpoint (Passport, CNIC, Visa, Ticket, Profile Picture).
     */
    public function uploadDocuments(Request $request): JsonResponse
    {
        return $this->updateProfile($request);
    }
}
