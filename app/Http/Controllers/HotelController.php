<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\City;
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
        $cities = City::where('status', 'active')->get();
        return view('hotel.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'distance'    => 'nullable|string|max:255',
            'star_rating' => 'required|in:1,2,3,4,5',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/hotels'), $filename);
            $data['image'] = $filename;
        }

        Hotel::create($data);

        return redirect()->route('hotel.index')->with('success', 'Hotel created successfully.');
    }

    public function edit($id)
    {
        $hotel  = Hotel::findOrFail($id);
        $cities = City::where('status', 'active')->get();
        return view('hotel.edit', compact('hotel', 'cities'));
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
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        if ($request->hasFile('image')) {
            if ($hotel->image) {
                $oldPath = public_path('assets/images/hotels/' . $hotel->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/hotels'), $filename);
            $data['image'] = $filename;
        }

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
