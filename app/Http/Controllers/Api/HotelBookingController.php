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
            'hotel_id'         => 'nullable|integer',
            'hotel_name'       => 'nullable|string|max:255',
            'guest_name'       => 'required|string|max:255',
            'contact_no'       => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'room_type'        => 'nullable|string',
            'check_in'         => 'nullable|date',
            'check_out'        => 'nullable|date',
            'no_of_rooms'      => 'nullable|integer|min:1',
            'meal'             => 'nullable|string|max:255',
            'documents_upload' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'passport_document'=> 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'payment_proof'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
        ]);

        $hotelId   = $request->hotel_id;
        $hotelName = $request->hotel_name;

        if (!empty($hotelId)) {
            $hotel = Hotel::find($hotelId);
            if ($hotel) {
                $hotelName = $hotel->name;
            } else {
                $hotelId = null;
            }
        }

        if (empty($hotelName)) {
            $hotelName = 'Custom Hotel Request';
        }

        $notes = $request->notes ?? $request->special_requests ?? $request->requirements;

        $data = [
            'user_id'     => $userId,
            'hotel_id'    => $hotelId ?: null,
            'hotel_name'  => $hotelName,
            'guest_name'  => $request->guest_name,
            'contact_no'  => $request->contact_no,
            'email'       => $request->email,
            'room_type'   => $request->room_type ?? 'sharing',
            'check_in'    => $request->check_in ?? now()->format('Y-m-d'),
            'check_out'   => $request->check_out ?? now()->addDays(1)->format('Y-m-d'),
            'no_of_rooms' => $request->no_of_rooms ?? 1,
            'meal'        => $request->meal ?? 'None',
            'notes'       => $notes,
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

        if ($request->hasFile('passport_document')) {
            $file = $request->file('passport_document');
            $filename = time() . '_passport_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['passport_document'] = 'uploads/hotel_bookings/' . $filename;
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
