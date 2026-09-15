<?php

namespace App\Http\Controllers;

use App\Models\FlightRequest;
use Illuminate\Http\Request;

class FlightRequestController extends Controller
{
    public function index()
    {
        $requests = FlightRequest::with('user')->latest()->get();
        return view('flight_request.index', compact('requests'));
    }

    public function show($id)
    {
        $requestItem = FlightRequest::with('user')->findOrFail($id);
        return view('flight_request.show', compact('requestItem'));
    }

    public function updateStatus(Request $request, $id)
    {
        $flightRequest = FlightRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,approved,cancelled',
        ]);

        $flightRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Flight request status updated successfully.');
    }

    public function destroy($id)
    {
        $flightRequest = FlightRequest::findOrFail($id);
        $flightRequest->delete();

        return redirect()->route('flight-request.index')->with('success', 'Flight request deleted successfully.');
    }
}
