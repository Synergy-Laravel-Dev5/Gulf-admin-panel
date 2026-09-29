<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PackageBooking;
use App\Models\HajjPackage;
use App\Models\UmrahPackage;
use App\Models\DomesticPackage;
use App\Models\InternationalPackage;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageBookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'package_type'        => 'nullable|string',
            'package_id'          => 'nullable|integer',
            'is_custom'           => 'nullable|boolean',
            'full_name'           => 'required|string|max:255',
            'cnic'                => 'nullable|string|max:20',
            'passport_number'     => 'nullable|string|max:50',
            'phone'               => 'required|string|max:20',
            'email'               => 'nullable|email',
            'room_type'           => 'nullable|string',
            'next_of_kin_name'    => 'nullable|string|max:255',
            'next_of_kin_contact' => 'nullable|string|max:20',
            'notes'               => 'nullable|string',
            'payment_proof'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
            'passport_document'   => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
            'documents_upload'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp,zip|max:10240',
        ]);

        $packageType = strtolower($request->package_type ?? '');
        $packageId   = $request->package_id;
        $isCustom    = $request->boolean('is_custom') || empty($packageId) || str_starts_with($packageType, 'custom');

        if ($isCustom) {
            $packageId = null;
            if (!$packageType || $packageType === 'package') {
                $packageType = 'custom_package';
            } elseif (!str_starts_with($packageType, 'custom_')) {
                $packageType = 'custom_' . $packageType;
            }
        } else {
            $packageExists = false;
            if ($packageType) {
                $packageExists = match ($packageType) {
                    'hajj'          => HajjPackage::where('id', $packageId)->exists(),
                    'umrah'         => UmrahPackage::where('id', $packageId)->exists(),
                    'domestic'      => DomesticPackage::where('id', $packageId)->exists(),
                    'international' => InternationalPackage::where('id', $packageId)->exists(),
                    'package'       => Package::where('id', $packageId)->exists(),
                    default         => false,
                };
            } else {
                if (HajjPackage::where('id', $packageId)->exists()) {
                    $packageType = 'hajj';
                    $packageExists = true;
                } elseif (UmrahPackage::where('id', $packageId)->exists()) {
                    $packageType = 'umrah';
                    $packageExists = true;
                } elseif (DomesticPackage::where('id', $packageId)->exists()) {
                    $packageType = 'domestic';
                    $packageExists = true;
                } elseif (InternationalPackage::where('id', $packageId)->exists()) {
                    $packageType = 'international';
                    $packageExists = true;
                } elseif (Package::where('id', $packageId)->exists()) {
                    $packageType = 'package';
                    $packageExists = true;
                }
            }

            if (!$packageExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected package does not exist.',
                ], 422);
            }
        }

        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $destinationPath = public_path('uploads/package_documents');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_pkg_proof_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $paymentProofPath = 'uploads/package_documents/' . $filename;
        }

        $passportDocPath = null;
        if ($request->hasFile('passport_document')) {
            $file = $request->file('passport_document');
            $filename = time() . '_passport_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $passportDocPath = 'uploads/package_documents/' . $filename;
        }

        $documentsUploadPath = null;
        if ($request->hasFile('documents_upload')) {
            $file = $request->file('documents_upload');
            $filename = time() . '_doc_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $documentsUploadPath = 'uploads/package_documents/' . $filename;
        }

        $booking = PackageBooking::create([
            'package_id'          => $packageId,
            'package_type'        => $packageType,
            'user_id'             => $userId,
            'full_name'           => $request->full_name,
            'cnic'                => $request->cnic ?? 'N/A',
            'passport_number'     => $request->passport_number,
            'phone'               => $request->phone,
            'email'               => $request->email,
            'room_type'           => $request->room_type ?? 'sharing',
            'next_of_kin_name'    => $request->next_of_kin_name,
            'next_of_kin_contact' => $request->next_of_kin_contact,
            'notes'               => $request->notes,
            'payment_proof'       => $paymentProofPath,
            'passport_document'   => $passportDocPath,
            'documents_upload'    => $documentsUploadPath,
            'status'              => 'pending',
        ]);

        $booking->load('package');

        return response()->json([
            'success' => true,
            'message' => 'Booking submitted successfully',
            'data'    => $booking,
        ], 201);
    }

    public function index(Request $request)
    {
        list($user, $isAdmin) = $this->getAuthenticatedUserAndAdminState();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $query = PackageBooking::with('package')->latest();

        if ($isAdmin) {
            if ($request->has('user_id') && !empty($request->user_id)) {
                $query->where('user_id', $request->user_id);
            }
        } else {
            $query->where('user_id', $user->id);
        }

        $bookings = $query->get();

        foreach ($bookings as $booking) {
            $this->formatBooking($booking);
        }

        return response()->json([
            'success' => true,
            'data'    => $bookings,
        ]);
    }

    public function show($id)
    {
        list($user, $isAdmin) = $this->getAuthenticatedUserAndAdminState();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $query = PackageBooking::with('package')->where('id', $id);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        $booking = $query->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found or access denied.',
            ], 404);
        }

        $this->formatBooking($booking);

        return response()->json([
            'success' => true,
            'data'    => $booking,
        ]);
    }

    private function getAuthenticatedUserAndAdminState()
    {
        $user = Auth::guard('sanctum')->user() ?? Auth::user();
        if (!$user) {
            return [null, false];
        }

        $role     = strtolower($user->role ?? '');
        $userType = strtolower($user->user_type ?? '');
        $isAdmin  = (
            $role === 'admin' || $role === 'super admin' || $role === 'super-admin' ||
            $userType === 'admin' || $userType === 'super admin' || $userType === 'super-admin' ||
            (method_exists($user, 'hasRole') && ($user->hasRole('admin') || $user->hasRole('Super Admin') || $user->hasRole('Admin')))
        );

        return [$user, $isAdmin];
    }

    private function formatBooking($booking)
    {
        if ($booking && $booking->package) {
            $pkg = $booking->package;
            if ($pkg->image) {
                if (str_contains($pkg->image, 'http://') || str_contains($pkg->image, 'https://')) {
                    $pkg->image_url = $pkg->image;
                } elseif (str_contains($pkg->image, '/')) {
                    $pkg->image_url = asset('storage/' . $pkg->image);
                } else {
                    $folder = strtolower($booking->package_type ?? 'package');
                    $pkg->image_url = asset('assets/images/packages/' . $folder . '/' . $pkg->image);
                }
            } else {
                $pkg->image_url = null;
            }
        }
        return $booking;
    }

    public function cancel(Request $request, $id = null)
    {
        $bookingId = $id ?? $request->id ?? $request->booking_id;
        list($user, $isAdmin) = $this->getAuthenticatedUserAndAdminState();

        if (!$user) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $query = PackageBooking::where('id', $bookingId);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        $booking = $query->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Booking not found or access denied.',
            ], 404);
        }

        $newStatus = strtolower($request->status ?? 'cancelled');
        $booking->update([
            'status' => $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Booking cancelled successfully.',
            'data'    => $booking,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->cancel($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->cancel($request, $id);
    }
}