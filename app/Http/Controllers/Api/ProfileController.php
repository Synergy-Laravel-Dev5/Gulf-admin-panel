<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'cnic_front'          => $user->cnic_front,
                'cnic_front_url'      => $user->cnic_front_url,
                'cnic_back'           => $user->cnic_back,
                'cnic_back_url'       => $user->cnic_back_url,
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
     * Update user profile information and upload documents (Profile Picture, Passport, CNIC Front, CNIC Back, Visa, Ticket).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'            => 'nullable|string|max:255',
            'phone'           => 'nullable|string|max:30',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'passport'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic_front'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'cnic_back'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
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

        // Direct public upload directory
        $destinationPath = public_path('uploads/user_documents');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->profile_picture = 'uploads/user_documents/' . $filename;
        }

        // Passport Document
        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $filename = time() . '_passport_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->passport = 'uploads/user_documents/' . $filename;
        }

        // CNIC / CNIC Front Document
        if ($request->hasFile('cnic_front')) {
            $file = $request->file('cnic_front');
            $filename = time() . '_cnic_front_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->cnic_front = 'uploads/user_documents/' . $filename;
            if (!$user->cnic) {
                $user->cnic = 'uploads/user_documents/' . $filename;
            }
        } elseif ($request->hasFile('cnic')) {
            $file = $request->file('cnic');
            $filename = time() . '_cnic_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->cnic = 'uploads/user_documents/' . $filename;
            $user->cnic_front = 'uploads/user_documents/' . $filename;
        }

        // CNIC Back Document
        if ($request->hasFile('cnic_back')) {
            $file = $request->file('cnic_back');
            $filename = time() . '_cnic_back_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->cnic_back = 'uploads/user_documents/' . $filename;
        }

        // Visa Document
        if ($request->hasFile('visa')) {
            $file = $request->file('visa');
            $filename = time() . '_visa_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->visa = 'uploads/user_documents/' . $filename;
        }

        // Ticket Document
        if ($request->hasFile('ticket')) {
            $file = $request->file('ticket');
            $filename = time() . '_ticket_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $user->ticket = 'uploads/user_documents/' . $filename;
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
                'cnic_front'          => $user->cnic_front,
                'cnic_front_url'      => $user->cnic_front_url,
                'cnic_back'           => $user->cnic_back,
                'cnic_back_url'       => $user->cnic_back_url,
                'visa'                => $user->visa,
                'visa_url'            => $user->visa_url,
                'ticket'              => $user->ticket,
                'ticket_url'          => $user->ticket_url,
            ]
        ]);
    }

    /**
     * Dedicated document upload endpoint (Passport, CNIC Front, CNIC Back, Visa, Ticket, Profile Picture).
     */
    public function uploadDocuments(Request $request): JsonResponse
    {
        return $this->updateProfile($request);
    }
}
