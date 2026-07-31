<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::latest()->get();
        return view('hotel.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'distance'    => 'nullable|string|max:255',
            'star_rating' => 'required|in:1,2,3,4,5',
            'status'      => 'required|in:active,inactive',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        Hotel::create($data);

        return redirect()->route('hotel.index')->with('success', 'Hotel created successfully.');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('hotel.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'distance'    => 'nullable|string|max:255',
            'star_rating' => 'required|in:1,2,3,4,5',
            'status'      => 'required|in:active,inactive',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        $hotel->update($data);

        return redirect()->route('hotel.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return back()->with('success', 'Hotel deleted successfully.');
    }
}
