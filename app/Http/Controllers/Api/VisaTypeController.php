<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisaType;
use Illuminate\Http\Request;

class VisaTypeController extends Controller
{
    public function index()
    {
        $visas = VisaType::with('country')
            ->where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $visas
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'visa_country_id'  => 'required|exists:visa_countries,id',
            'visa_name'        => 'required|string|max:255',
            'b2b_rate'         => 'nullable|string',
            'visa_fee'         => 'nullable|string',
            'processing_time'  => 'nullable|string',
            'requirements'     => 'nullable|array',
            'requirements.*'   => 'string',
            'notes'            => 'nullable|string',
        ]);


        $visa = VisaType::create($validated);


        return response()->json([
            'status' => true,
            'message' => 'Visa created successfully',
            'data' => $visa
        ], 201);
    }


    public function show($id)
    {
        $visa = VisaType::with('country')->find($id);


        if (!$visa) {
            return response()->json([
                'status' => false,
                'message' => 'Visa not found'
            ], 404);
        }


        return response()->json([
            'status' => true,
            'data' => $visa
        ]);
    }


    public function update(Request $request, $id)
    {
        $visa = VisaType::find($id);


        if (!$visa) {
            return response()->json([
                'status' => false,
                'message' => 'Visa not found'
            ], 404);
        }


        $validated = $request->validate([
            'visa_country_id'  => 'sometimes|exists:visa_countries,id',
            'visa_name'        => 'sometimes|string|max:255',
            'b2b_rate'         => 'nullable|string',
            'visa_fee'         => 'nullable|string',
            'processing_time'  => 'nullable|string',
            'requirements'     => 'nullable|array',
            'requirements.*'   => 'string',
            'notes'            => 'nullable|string',
            'is_active'        => 'sometimes|boolean',
        ]);


        $visa->update($validated);


        return response()->json([
            'status' => true,
            'message' => 'Visa updated successfully',
            'data' => $visa
        ]);
    }


    public function destroy($id)
    {
        $visa = VisaType::find($id);


        if (!$visa) {
            return response()->json([
                'status' => false,
                'message' => 'Visa not found'
            ], 404);
        }


        $visa->delete();


        return response()->json([
            'status' => true,
            'message' => 'Visa deleted successfully'
        ]);
    }
}
