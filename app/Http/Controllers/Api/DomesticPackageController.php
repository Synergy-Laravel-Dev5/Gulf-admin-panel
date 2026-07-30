<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DomesticPackage;

class DomesticPackageController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => DomesticPackage::where('status', 'active')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $package = DomesticPackage::where('status', 'active')->find($id);

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
