<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HajjPackage;

class HajjPackageController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => HajjPackage::with('transportation')->where('status', 'active')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $package = HajjPackage::with('transportation')->where('status', 'active')->find($id);

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
