<?php

namespace App\Http\Controllers;

use App\Models\DomesticPackage;
use Illuminate\Http\Request;

class DomesticPackageController extends Controller
{
    public function index()
    {
        $packages = DomesticPackage::latest()->get();
        return view('domestic_package.index', compact('packages'));
    }

    public function create()
    {
        return view('domestic_package.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'departure_city'     => 'nullable|string|max:255',
            'destination_city'   => 'required|string|max:255',
            'hotel_name'         => 'nullable|string|max:255',
            'hotel_rating'       => 'nullable|string|max:255',
            'duration_days'      => 'nullable|integer',
            'travel_date_from'   => 'nullable|date',
            'travel_date_to'     => 'nullable|date|after_or_equal:travel_date_from',
            'price_per_person'   => 'nullable|numeric',
            'features'           => 'nullable|string',
            'requirements'       => 'nullable|string',
            'description'        => 'nullable|string',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'             => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages/domestic', 'public');
        }

        DomesticPackage::create($data);

        return redirect()->route('domestic-package.index')->with('success', 'Domestic package created successfully.');
    }

    public function edit($id)
    {
        $package = DomesticPackage::findOrFail($id);
        return view('domestic_package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = DomesticPackage::findOrFail($id);

        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'departure_city'     => 'nullable|string|max:255',
            'destination_city'   => 'required|string|max:255',
            'hotel_name'         => 'nullable|string|max:255',
            'hotel_rating'       => 'nullable|string|max:255',
            'duration_days'      => 'nullable|integer',
            'travel_date_from'   => 'nullable|date',
            'travel_date_to'     => 'nullable|date|after_or_equal:travel_date_from',
            'price_per_person'   => 'nullable|numeric',
            'features'           => 'nullable|string',
            'requirements'       => 'nullable|string',
            'description'        => 'nullable|string',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'             => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages/domestic', 'public');
        }

        $package->update($data);

        return redirect()->route('domestic-package.index')->with('success', 'Domestic package updated successfully.');
    }

    public function destroy($id)
    {
        DomesticPackage::findOrFail($id)->delete();
        return back()->with('success', 'Package moved to trash.');
    }

    public function trash()
    {
        $packages = DomesticPackage::onlyTrashed()->latest()->get();
        return view('domestic_package.trash', compact('packages'));
    }

    public function restore($id)
    {
        DomesticPackage::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Package restored successfully.');
    }
}
