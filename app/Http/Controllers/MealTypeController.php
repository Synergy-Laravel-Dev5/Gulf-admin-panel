<?php

namespace App\Http\Controllers;

use App\Models\MealType;
use Illuminate\Http\Request;

class MealTypeController extends Controller
{
    public function index()
    {
        $mealTypes = MealType::latest()->get();
        return view('meal_type.index', compact('mealTypes'));
    }

    public function create()
    {
        return view('meal_type.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255|unique:meal_types,name',
            'status' => 'required|in:active,inactive',
        ]);

        MealType::create($data);

        return redirect()->route('meal-type.index')->with('success', 'Meal type created successfully.');
    }

    public function edit($id)
    {
        $mealType = MealType::findOrFail($id);
        return view('meal_type.edit', compact('mealType'));
    }

    public function update(Request $request, $id)
    {
        $mealType = MealType::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:255|unique:meal_types,name,' . $mealType->id,
            'status' => 'required|in:active,inactive',
        ]);

        $mealType->update($data);

        return redirect()->route('meal-type.index')->with('success', 'Meal type updated successfully.');
    }

    public function destroy($id)
    {
        MealType::findOrFail($id)->delete();
        return back()->with('success', 'Meal type moved to trash.');
    }

    public function trash()
    {
        $mealTypes = MealType::onlyTrashed()->latest()->get();
        return view('meal_type.trash', compact('mealTypes'));
    }

    public function restore($id)
    {
        MealType::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Meal type restored successfully.');
    }
}
