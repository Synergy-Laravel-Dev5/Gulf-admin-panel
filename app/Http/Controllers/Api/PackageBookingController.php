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
            'package_type'        => 'nullable|string|in:hajj,umrah,domestic,international,package',
            'package_id'          => 'required|integer',
            'full_name'           => 'required|string|max:255',
            'cnic'                => 'required|string|max:20',
            'passport_number'     => 'nullable|string|max:50',
            'phone'               => 'required|string|max:20',
            'email'               => 'nullable|email',
            'room_type'           => 'required|in:sharing,triple,double',
            'next_of_kin_name'    => 'nullable|string|max:255',
            'next_of_kin_contact' => 'nullable|string|max:20',
            'notes'               => 'nullable|string',
        ]);

        $packageType = strtolower($request->package_type ?? '');
        $packageId   = $request->package_id;
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

        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $booking = PackageBooking::create([
            'package_id'          => $packageId,
            'package_type'        => $packageType,
            'user_id'             => $userId,
            'full_name'           => $request->full_name,
            'cnic'                => $request->cnic,
            'passport_number'     => $request->passport_number,
            'phone'               => $request->phone,
            'email'               => $request->email,
            'room_type'           => $request->room_type,
            'next_of_kin_name'    => $request->next_of_kin_name,
            'next_of_kin_contact' => $request->next_of_kin_contact,
            'notes'               => $request->notes,
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
        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $bookings = PackageBooking::with('package')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $bookings,
        ]);
    }

    public function show($id)
    {
        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $booking = PackageBooking::with('package')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $booking,
        ]);
    }
}