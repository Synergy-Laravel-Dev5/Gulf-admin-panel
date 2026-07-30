<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisaCountry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisaCountryController extends Controller
{
    public function index(): JsonResponse
    {
        $countries = VisaCountry::where('is_active', true)
            ->orderBy('country_name')
            ->get(['id', 'country_name', 'country_code']);

        return response()->json([
            'status' => true,
            'data'   => $countries,
        ]);
    }


    public function show(int $id): JsonResponse
    {
        $country = VisaCountry::with('visaTypes')
            ->find($id);

        if (!$country) {
            return response()->json([
                'status' => false,
                'message' => 'Country not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $country
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'country_name' => 'required|string|max:255',
            'country_code' => 'nullable|string|max:2',
            'is_active'    => 'nullable|boolean',
        ]);

        $country = VisaCountry::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Country created successfully',
            'data' => $country
        ], 201);
    }


    public function update(Request $request, int $id): JsonResponse
    {
        $country = VisaCountry::find($id);

        if (!$country) {
            return response()->json([
                'status' => false,
                'message' => 'Country not found'
            ], 404);
        }

        $validated = $request->validate([
            'country_name' => 'sometimes|string|max:255',
            'country_code' => 'sometimes|nullable|string|max:2',
            'is_active'    => 'sometimes|boolean',
        ]);

        $country->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Country updated successfully',
            'data' => $country
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $country = VisaCountry::find($id);

        if (!$country) {
            return response()->json([
                'status' => false,
                'message' => 'Country not found'
            ], 404);
        }

        $country->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }


    public function visas($id): JsonResponse
    {
        $country = VisaCountry::with('visaTypes')
            ->find($id);

        if (!$country) {
            return response()->json([
                'status' => false,
                'message' => 'Country not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $country->visaTypes
        ]);
    }
}
