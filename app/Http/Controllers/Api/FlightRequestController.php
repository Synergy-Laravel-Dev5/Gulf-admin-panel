<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlightRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'guest_name'        => 'required|string|max:255',
            'phone'             => 'required|string|max:50',
            'email'             => 'nullable|email|max:255',
            'trip_type'         => 'nullable|string|in:one_way,return,multi_city',
            'leaving_from'      => 'required|string|max:255',
            'going_to'          => 'required|string|max:255',
            'departure_date'    => 'required|date',
            'return_date'       => 'nullable|date',
            'adults'            => 'nullable|integer|min:1',
            'children'          => 'nullable|integer|min:0',
            'infants'           => 'nullable|integer|min:0',
            'cabin_class'       => 'nullable|string|max:100',
            'multi_city_legs'   => 'nullable',
            'notes'             => 'nullable|string',
            'passport_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            'documents_upload'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp,zip|max:10240',
        ]);

        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $multiCityLegs = $request->multi_city_legs;
        if (is_string($multiCityLegs)) {
            $decoded = json_decode($multiCityLegs, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $multiCityLegs = $decoded;
            }
        }

        $data = [
            'user_id'          => $userId,
            'guest_name'       => $request->guest_name,
            'phone'            => $request->phone,
            'email'            => $request->email,
            'trip_type'        => strtolower($request->trip_type ?? 'one_way'),
            'leaving_from'     => $request->leaving_from,
            'going_to'         => $request->going_to,
            'departure_date'   => $request->departure_date,
            'return_date'      => $request->return_date,
            'adults'           => $request->adults ?? 1,
            'children'         => $request->children ?? 0,
            'infants'          => $request->infants ?? 0,
            'cabin_class'      => strtolower($request->cabin_class ?? 'economy'),
            'multi_city_legs'  => $multiCityLegs,
            'notes'            => $request->notes ?? $request->special_requests,
            'status'           => 'pending',
        ];

        $destinationPath = public_path('uploads/flight_requests');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('passport_document')) {
            $file = $request->file('passport_document');
            $filename = time() . '_passport_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['passport_document'] = 'uploads/flight_requests/' . $filename;
        }

        if ($request->hasFile('documents_upload')) {
            $file = $request->file('documents_upload');
            $filename = time() . '_doc_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['documents_upload'] = 'uploads/flight_requests/' . $filename;
        }

        $flightRequest = FlightRequest::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Flight request submitted successfully.',
            'data'    => $flightRequest,
        ], 201);
    }

    public function index()
    {
        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $requests = FlightRequest::where('user_id', $userId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $requests,
        ]);
    }

    public function show($id)
    {
        $userId = Auth::guard('sanctum')->id() ?? Auth::id();

        $request = FlightRequest::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'Flight request not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $request,
        ]);
    }

    public function cancel(Request $request, $id = null)
    {
        $requestId = $id ?? $request->id ?? $request->request_id;
        $userId    = Auth::guard('sanctum')->id() ?? Auth::id();

        $query = FlightRequest::query();
        if ($requestId) {
            $query->where('id', $requestId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $flightReq = $query->first();

        if (!$flightReq) {
            $flightReq = FlightRequest::find($requestId);
        }

        if (!$flightReq) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Flight request not found.',
            ], 404);
        }

        $newStatus = strtolower($request->status ?? 'cancelled');
        $flightReq->update([
            'status' => $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Flight request cancelled successfully.',
            'data'    => $flightReq,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->cancel($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->cancel($request, $id);
    }
}
