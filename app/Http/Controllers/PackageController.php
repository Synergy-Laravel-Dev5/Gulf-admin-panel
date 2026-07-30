<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Hotel;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('package.index', compact('packages'));
    }

    public function create()
    {
        $makkahHotels  = Hotel::where('city', 'makkah')->where('status', 'active')->get();
        $madinahHotels = Hotel::where('city', 'madinah')->where('status', 'active')->get();

        return view('package.create', compact('makkahHotels', 'madinahHotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'                   => 'required|in:hajj,umrah',
            'title'                  => 'required|string|max:255',
            'subtitle'                => 'nullable|string|max:255',
            'makkah_hotel_name'       => 'nullable|string|max:255',
            'makkah_hotel_distance'   => 'nullable|string|max:255',
            'madinah_hotel_name'      => 'nullable|string|max:255',
            'madinah_hotel_distance'  => 'nullable|string|max:255',
            'travel_date_from'        => 'nullable|date',
            'travel_date_to'          => 'nullable|date|after_or_equal:travel_date_from',
            'price_sharing'           => 'nullable|numeric',
            'price_triple'            => 'nullable|numeric',
            'price_double'            => 'nullable|numeric',
            'features'                => 'nullable|string',
            'requirements'            => 'nullable|string',
            'description'             => 'nullable|string',
            'image'                   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'                  => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        Package::create($data);

        return redirect()->route('package.index')->with('success', 'Package created successfully.');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);

        $makkahHotels  = Hotel::where('city', 'makkah')->where('status', 'active')->get();
        $madinahHotels = Hotel::where('city', 'madinah')->where('status', 'active')->get();

        return view('package.edit', compact('package', 'makkahHotels', 'madinahHotels'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'type'                   => 'required|in:hajj,umrah',
            'title'                  => 'required|string|max:255',
            'subtitle'                => 'nullable|string|max:255',
            'makkah_hotel_name'       => 'nullable|string|max:255',
            'makkah_hotel_distance'   => 'nullable|string|max:255',
            'madinah_hotel_name'      => 'nullable|string|max:255',
            'madinah_hotel_distance'  => 'nullable|string|max:255',
            'travel_date_from'        => 'nullable|date',
            'travel_date_to'          => 'nullable|date|after_or_equal:travel_date_from',
            'price_sharing'           => 'nullable|numeric',
            'price_triple'            => 'nullable|numeric',
            'price_double'            => 'nullable|numeric',
            'features'                => 'nullable|string',
            'requirements'            => 'nullable|string',
            'description'             => 'nullable|string',
            'image'                   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'                  => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);

        return redirect()->route('package.index')->with('success', 'Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return back()->with('success', 'Package moved to trash.');
    }

    public function trash()
    {
        $packages = Package::onlyTrashed()->latest()->get();
        return view('package.trash', compact('packages'));
    }

    public function restore($id)
    {
        $package = Package::onlyTrashed()->findOrFail($id);
        $package->restore();

        return back()->with('success', 'Package restored successfully.');
    }
}
