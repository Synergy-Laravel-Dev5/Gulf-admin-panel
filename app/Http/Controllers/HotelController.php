<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\City;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('images')->latest()->get();
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
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        $destinationPath = public_path('uploads/hotels');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/hotels/' . $filename;
        }

        $hotel = Hotel::create($data);

        // Multiple Images Upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $multiFile) {
                $multiFilename = time() . '_gallery_' . uniqid() . '.' . $multiFile->getClientOriginalExtension();
                $multiFile->move($destinationPath, $multiFilename);

                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'image'    => 'uploads/hotels/' . $multiFilename,
                ]);
            }
        }

        return redirect()->route('hotel.index')->with('success', 'Hotel created successfully.');
    }

    public function edit($id)
    {
        $hotel  = Hotel::with('images')->findOrFail($id);
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
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data['city'] = strtolower(trim($data['city']));

        $destinationPath = public_path('uploads/hotels');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/hotels/' . $filename;
        }

        $hotel->update($data);

        // Upload new additional gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $multiFile) {
                $multiFilename = time() . '_gallery_' . uniqid() . '.' . $multiFile->getClientOriginalExtension();
                $multiFile->move($destinationPath, $multiFilename);

                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'image'    => 'uploads/hotels/' . $multiFilename,
                ]);
            }
        }

        return redirect()->route('hotel.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroyImage($imageId)
    {
        $image = HotelImage::findOrFail($imageId);
        $image->delete();
        return back()->with('success', 'Image deleted successfully.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return back()->with('success', 'Hotel deleted successfully.');
    }
}
