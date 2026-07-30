<?php

namespace App\Http\Controllers;

use App\Models\HajjPackage;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HajjPackageController extends Controller
{
    public function index()
    {
        $packages = HajjPackage::latest()->get();
        return view('hajj_package.index', compact('packages'));
    }

    public function create()
    {
        $makkahHotels  = Hotel::where('city', 'makkah')->where('status', 'active')->get();
        $madinahHotels = Hotel::where('city', 'madinah')->where('status', 'active')->get();
        return view('hajj_package.create', compact('makkahHotels', 'madinahHotels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                  => 'required|string|max:255',
            'subtitle'               => 'nullable|string|max:255',
            'makkah_hotel_name'      => 'nullable|string|max:255',
            'makkah_hotel_distance'  => 'nullable|string|max:255',
            'madinah_hotel_name'     => 'nullable|string|max:255',
            'madinah_hotel_distance' => 'nullable|string|max:255',
            'travel_date_from'       => 'nullable|date',
            'travel_date_to'         => 'nullable|date|after_or_equal:travel_date_from',
            'price_sharing'          => 'nullable|numeric',
            'price_triple'           => 'nullable|numeric',
            'price_double'           => 'nullable|numeric',
            'features'               => 'nullable|string',
            'requirements'           => 'nullable|string',
            'description'            => 'nullable|string',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'                 => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages/hajj', 'public');
        }

        HajjPackage::create($data);

        return redirect()->route('hajj-package.index')->with('success', 'Hajj package created successfully.');
    }

    public function edit($id)
    {
        $package = HajjPackage::findOrFail($id);
        $makkahHotels  = Hotel::where('city', 'makkah')->where('status', 'active')->get();
        $madinahHotels = Hotel::where('city', 'madinah')->where('status', 'active')->get();
        return view('hajj_package.edit', compact('package', 'makkahHotels', 'madinahHotels'));
    }

    public function update(Request $request, $id)
    {
        $package = HajjPackage::findOrFail($id);

        $data = $request->validate([
            'title'                  => 'required|string|max:255',
            'subtitle'               => 'nullable|string|max:255',
            'makkah_hotel_name'      => 'nullable|string|max:255',
            'makkah_hotel_distance'  => 'nullable|string|max:255',
            'madinah_hotel_name'     => 'nullable|string|max:255',
            'madinah_hotel_distance' => 'nullable|string|max:255',
            'travel_date_from'       => 'nullable|date',
            'travel_date_to'         => 'nullable|date|after_or_equal:travel_date_from',
            'price_sharing'          => 'nullable|numeric',
            'price_triple'           => 'nullable|numeric',
            'price_double'           => 'nullable|numeric',
            'features'               => 'nullable|string',
            'requirements'           => 'nullable|string',
            'description'            => 'nullable|string',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'                 => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages/hajj', 'public');
        }

        $package->update($data);

        return redirect()->route('hajj-package.index')->with('success', 'Hajj package updated successfully.');
    }

    public function destroy($id)
    {
        HajjPackage::findOrFail($id)->delete();
        return back()->with('success', 'Package moved to trash.');
    }

    public function trash()
    {
        $packages = HajjPackage::onlyTrashed()->latest()->get();
        return view('hajj_package.trash', compact('packages'));
    }

    public function restore($id)
    {
        HajjPackage::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Package restored successfully.');
    }
}
