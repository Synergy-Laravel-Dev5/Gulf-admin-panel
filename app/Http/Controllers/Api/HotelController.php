<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Get list of active hotels with optional city and star rating filters.
     */
    public function index(Request $request)
    {
        $query = Hotel::with('images')->where('status', 'active');

        // Filter by City if provided
        if ($request->filled('city')) {
            $query->where('city', 'LIKE', strtolower(trim($request->city)));
        }

        // Filter by Star Rating if provided
        if ($request->filled('star_rating')) {
            $query->where('star_rating', $request->star_rating);
        } elseif ($request->filled('stars')) {
            $query->where('star_rating', $request->stars);
        }

        $hotels = $query->latest()->get();

        return response()->json([
            'success' => true,
            'count'   => $hotels->count(),
            'data'    => $hotels,
        ]);
    }

    /**
     * Get list of available cities with active hotels.
     */
    public function cities()
    {
        $cities = Hotel::where('status', 'active')
            ->distinct()
            ->pluck('city')
            ->map(fn($city) => strtolower($city))
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $cities,
        ]);
    }

    /**
     * Get single hotel details by ID.
     */
    public function show($id)
    {
        $hotel = Hotel::with('images')->where('status', 'active')->find($id);

        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $hotel,
        ]);
    }
}
