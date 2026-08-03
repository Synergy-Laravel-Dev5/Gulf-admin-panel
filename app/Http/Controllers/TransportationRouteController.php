<?php

namespace App\Http\Controllers;

use App\Models\TransportationRoute;
use Illuminate\Http\Request;

class TransportationRouteController extends Controller
{
    public function index()
    {
        $routes = TransportationRoute::latest()->get();
        return view('transportation_route.index', compact('routes'));
    }

    public function create()
    {
        return view('transportation_route.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:255|unique:transportation_routes,code',
            'status' => 'required|in:active,inactive',
        ]);

        $data['code'] = strtolower(trim($data['code']));

        TransportationRoute::create($data);

        return redirect()->route('transportation-route.index')->with('success', 'Transportation route created successfully.');
    }

    public function edit($id)
    {
        $route = TransportationRoute::findOrFail($id);
        return view('transportation_route.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = TransportationRoute::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|max:255|unique:transportation_routes,code,' . $route->id,
            'status' => 'required|in:active,inactive',
        ]);

        $data['code'] = strtolower(trim($data['code']));

        $route->update($data);

        return redirect()->route('transportation-route.index')->with('success', 'Transportation route updated successfully.');
    }

    public function destroy($id)
    {
        TransportationRoute::findOrFail($id)->delete();
        return back()->with('success', 'Transportation route moved to trash.');
    }

    public function trash()
    {
        $routes = TransportationRoute::onlyTrashed()->latest()->get();
        return view('transportation_route.trash', compact('routes'));
    }

    public function restore($id)
    {
        TransportationRoute::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Transportation route restored successfully.');
    }
}
