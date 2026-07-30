<?php

namespace App\Http\Controllers;

use App\Models\PackageBooking;
use Illuminate\Http\Request;

class PackageBookingController extends Controller
{
    public function index()
    {
        $bookings = PackageBooking::with('package')->latest()->get();
        return view('package-booking.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = PackageBooking::with('package', 'user')->findOrFail($id);
        return view('package-booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = PackageBooking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy($id)
    {
        $booking = PackageBooking::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }
}
