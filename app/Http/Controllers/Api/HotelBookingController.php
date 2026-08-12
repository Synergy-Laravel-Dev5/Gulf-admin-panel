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
            'contact_no'       => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'room_type'        => 'required|in:sharing,double,triple,quad,quint',
            'check_in'         => 'required|date',
            'check_out'        => 'required|date|after:check_in',
            'no_of_rooms'      => 'required|integer|min:1',
            'meal'             => 'required|string|max:255',
            'documents_upload' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'payment_proof'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
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
            'contact_no'  => $request->contact_no,
            'email'       => $request->email,
            'room_type'   => $request->room_type,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'no_of_rooms' => $request->no_of_rooms,
            'meal'        => $request->meal,
            'status'      => 'pending',
        ];

        $destinationPath = public_path('uploads/hotel_bookings');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('documents_upload')) {
            $file = $request->file('documents_upload');
            $filename = time() . '_doc_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['documents_upload'] = 'uploads/hotel_bookings/' . $filename;
        }

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_proof_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['payment_proof'] = 'uploads/hotel_bookings/' . $filename;
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
