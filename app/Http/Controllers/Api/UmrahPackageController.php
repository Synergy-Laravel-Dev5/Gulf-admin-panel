<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UmrahPackage;

class UmrahPackageController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => UmrahPackage::where('status', 'active')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $package = UmrahPackage::where('status', 'active')->find($id);

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
