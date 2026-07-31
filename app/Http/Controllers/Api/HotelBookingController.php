<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelBookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id'         => 'required|integer',
            'guest_name'       => 'required|string|max:255',
            'room_type'        => 'required|in:sharing,double,triple,quad,quint',
            'check_in'         => 'required|date',
            'check_out'        => 'required|date|after:check_in',
            'no_of_rooms'      => 'required|integer|min:1',
            'meal'             => 'required|string|max:255',
            'documents_upload' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $hotel = Hotel::find($request->hotel_id);
        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found.',
            ], 404);
        }

        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $data = [
            'user_id'     => $userId,
            'hotel_id'    => $hotel->id,
            'hotel_name'  => $hotel->name,
            'guest_name'  => $request->guest_name,
            'room_type'   => $request->room_type,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'no_of_rooms' => $request->no_of_rooms,
            'meal'        => $request->meal,
            'status'      => 'pending',
        ];

        if ($request->hasFile('documents_upload')) {
            $data['documents_upload'] = $request->file('documents_upload')->store('hotel_bookings/documents', 'public');
        }

        $booking = HotelBooking::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Hotel request sent successfully.',
            'data'    => $booking,
        ], 201);
    }

    public function index()
    {
        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $bookings = HotelBooking::where('user_id', $userId)
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

        $booking = HotelBooking::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel request booking not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $booking,
        ]);
    }
}
