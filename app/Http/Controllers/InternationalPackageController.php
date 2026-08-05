<?php

namespace App\Http\Controllers;

use App\Models\InternationalPackage;
use App\Models\Hotel;
use Illuminate\Http\Request;

class InternationalPackageController extends Controller
{
    public function index()
    {
        $packages = InternationalPackage::latest()->get();
        return view('international_package.index', compact('packages'));
    }

    public function create()
    {
        $hotels = Hotel::where('status', 'active')->get();
        return view('international_package.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'subtitle'             => 'nullable|string|max:255',
            'departure_city'       => 'nullable|string|max:255',
            'destination_country'  => 'required|string|max:255',
            'destination_city'     => 'nullable|string|max:255',
            'hotel_name'           => 'nullable|string|max:255',
            'star_rating'          => 'nullable|string|max:255',
            'visa_required'        => 'nullable|boolean',
            'duration_days'        => 'nullable|integer',
            'travel_date_from'     => 'nullable|date',
            'travel_date_to'       => 'nullable|date|after_or_equal:travel_date_from',
            'price_per_person'     => 'nullable|numeric',
            'features'             => 'nullable|string',
            'requirements'         => 'nullable|string',
            'description'          => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'               => 'required|in:active,inactive',
        ]);

        $data['visa_required'] = $request->boolean('visa_required');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/packages/international'), $filename);
            $data['image'] = $filename;
        }

        InternationalPackage::create($data);

        return redirect()->route('international-package.index')->with('success', 'International package created successfully.');
    }

    public function edit($id)
    {
        $package = InternationalPackage::findOrFail($id);
        $hotels  = Hotel::where('status', 'active')->get();
        return view('international_package.edit', compact('package', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $package = InternationalPackage::findOrFail($id);

        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'subtitle'             => 'nullable|string|max:255',
            'departure_city'       => 'nullable|string|max:255',
            'destination_country'  => 'required|string|max:255',
            'destination_city'     => 'nullable|string|max:255',
            'hotel_name'           => 'nullable|string|max:255',
            'star_rating'          => 'nullable|string|max:255',
            'visa_required'        => 'nullable|boolean',
            'duration_days'        => 'nullable|integer',
            'travel_date_from'     => 'nullable|date',
            'travel_date_to'       => 'nullable|date|after_or_equal:travel_date_from',
            'price_per_person'     => 'nullable|numeric',
            'features'             => 'nullable|string',
            'requirements'         => 'nullable|string',
            'description'          => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'               => 'required|in:active,inactive',
        ]);

        $data['visa_required'] = $request->boolean('visa_required');

        if ($request->hasFile('image')) {
            if ($package->image) {
                $oldPath = public_path('assets/images/packages/international/' . $package->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/packages/international'), $filename);
            $data['image'] = $filename;
        }

        $package->update($data);

        return redirect()->route('international-package.index')->with('success', 'International package updated successfully.');
    }

    public function destroy($id)
    {
        InternationalPackage::findOrFail($id)->delete();
        return back()->with('success', 'Package moved to trash.');
    }

    public function trash()
    {
        $packages = InternationalPackage::onlyTrashed()->latest()->get();
        return view('international_package.trash', compact('packages'));
    }

    public function restore($id)
    {
        InternationalPackage::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Package restored successfully.');
    }
}
