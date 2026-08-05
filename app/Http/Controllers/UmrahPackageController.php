<?php

namespace App\Http\Controllers;

use App\Models\UmrahPackage;
use App\Models\Hotel;
use Illuminate\Http\Request;

class UmrahPackageController extends Controller
{
    
    public function index()
    {
        $packages = UmrahPackage::latest()->get();
        return view('umrah_package.index', compact('packages'));
    }

    public function create()
    {
        $makkahHotels  = Hotel::where('city', 'makkah')->where('status', 'active')->get();
        $madinahHotels = Hotel::where('city', 'madinah')->where('status', 'active')->get();

        return view('umrah_package.create', compact('makkahHotels', 'madinahHotels'));
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
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/packages/umrah'), $filename);
            $data['image'] = $filename;
        }

        UmrahPackage::create($data);

        return redirect()->route('umrah-package.index')->with('success', 'Umrah package created successfully.');
    }

   
    public function show($id)
    {
        $umrahPackage = UmrahPackage::findOrFail($id);
        return view('umrah_package.show', compact('umrahPackage'));
    }

    public function edit($id)
    {
        $umrahPackage = UmrahPackage::findOrFail($id);
        $makkahHotels  = Hotel::whereRaw('LOWER(city) = ?', ['makkah'])->where('status', 'active')->get();
        $madinahHotels = Hotel::whereRaw('LOWER(city) = ?', ['madinah'])->where('status', 'active')->get();

        return view('umrah_package.edit', compact('umrahPackage', 'makkahHotels', 'madinahHotels'));
    }

    public function update(Request $request, $id)
    {
        $umrahPackage = UmrahPackage::findOrFail($id);

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
            if ($umrahPackage->image) {
                $oldPath = public_path('assets/images/packages/umrah/' . $umrahPackage->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/packages/umrah'), $filename);
            $data['image'] = $filename;
        }

        $umrahPackage->update($data);

        return redirect()->route('umrah-package.index')->with('success', 'Umrah package updated successfully.');
    }

    public function destroy($id)
    {
        $umrahPackage = UmrahPackage::findOrFail($id);
        $umrahPackage->delete();

        return back()->with('success', 'Package moved to trash.');
    }

    public function trash()
    {
        $packages = UmrahPackage::onlyTrashed()->latest()->get();
        return view('umrah_package.trash', compact('packages'));
    }

 
    public function restore($id)
    {
        UmrahPackage::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Package restored successfully.');
    }
}
