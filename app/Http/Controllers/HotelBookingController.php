<?php

namespace App\Http\Controllers;

use App\Models\HotelBooking;
use Illuminate\Http\Request;

class HotelBookingController extends Controller
{
    public function index()
    {
        $bookings = HotelBooking::with(['hotel', 'user'])->latest()->get();
        return view('hotel_booking.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = HotelBooking::with(['hotel', 'user'])->findOrFail($id);
        return view('hotel_booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = HotelBooking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy($id)
    {
        $booking = HotelBooking::findOrFail($id);
        $booking->delete();

        return redirect()->route('hotel-booking.index')->with('success', 'Booking moved to trash.');
    }
}
