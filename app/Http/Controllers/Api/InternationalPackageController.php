<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalPackage;

class InternationalPackageController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => InternationalPackage::where('status', 'active')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $package = InternationalPackage::where('status', 'active')->find($id);

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