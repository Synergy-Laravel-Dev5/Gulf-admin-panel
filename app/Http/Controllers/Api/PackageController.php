<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::where('status', 'active');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $packages = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $packages,
        ]);
    }

    public function show($id)
    {
        $package = Package::where('status', 'active')->find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $package,
        ]);
    }
}
