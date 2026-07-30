<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageBookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'package_id'          => 'required|exists:packages,id',
            'full_name'           => 'required|string|max:255',
            'cnic'                => 'required|string|max:20',
            'passport_number'     => 'nullable|string|max:50',
            'phone'               => 'required|string|max:20',
            'email'               => 'nullable|email',
            'room_type'           => 'required|in:sharing,triple,double',
            'next_of_kin_name'    => 'nullable|string|max:255',
            'next_of_kin_contact' => 'nullable|string|max:20',
        ]);

        $booking = PackageBooking::create([
            'package_id'          => $request->package_id,
            'user_id'             => Auth::id(), 
            'full_name'           => $request->full_name,
            'cnic'                => $request->cnic,
            'passport_number'     => $request->passport_number,
            'phone'               => $request->phone,
            'email'               => $request->email,
            'room_type'           => $request->room_type,
            'next_of_kin_name'    => $request->next_of_kin_name,
            'next_of_kin_contact' => $request->next_of_kin_contact,
            'status'              => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking submitted successfully',
            'data'    => $booking,
        ], 201);
    }

    public function index(Request $request)
    {
        $bookings = PackageBooking::with('package')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $bookings,
        ]);
    }
}