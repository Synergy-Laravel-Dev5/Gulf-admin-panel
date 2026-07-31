<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::latest()->get();
        return view('city.index', compact('cities'));
    }

    public function create()
    {
        return view('city.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:cities,name',
            'country' => 'nullable|string|max:255',
            'status'  => 'required|in:active,inactive',
        ]);

        City::create($data);

        return redirect()->route('city.index')->with('success', 'City created successfully.');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('city.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:cities,name,' . $city->id,
            'country' => 'nullable|string|max:255',
            'status'  => 'required|in:active,inactive',
        ]);

        $city->update($data);

        return redirect()->route('city.index')->with('success', 'City updated successfully.');
    }

    public function destroy($id)
    {
        City::findOrFail($id)->delete();
        return back()->with('success', 'City moved to trash.');
    }

    public function trash()
    {
        $cities = City::onlyTrashed()->latest()->get();
        return view('city.trash', compact('cities'));
    }

    public function restore($id)
    {
        City::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'City restored successfully.');
    }
}
