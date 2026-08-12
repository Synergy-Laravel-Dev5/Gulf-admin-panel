<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisaApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisaApplicationController extends Controller
{
    public function index(): JsonResponse
    {
        $applications = VisaApplication::with('visaType.country')
            ->latest()
            ->paginate(20);


        return response()->json([
            'status' => true,
            'data' => $applications
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [

            'visa_type_id' => 'required|exists:visa_types,id',

            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',

            'cnic' => 'nullable|string|max:20',

            'passport_scan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'cnic_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'cnic_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'bank_statement' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'other_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);


        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }


        $data = $validator->validated();


        $destinationPath = public_path('uploads/visa_documents');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        foreach (
            [
                'passport_scan',
                'picture',
                'cnic_front',
                'cnic_back',
                'bank_statement',
                'other_document'
            ] as $field
        ) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $data[$field] = 'uploads/visa_documents/' . $filename;
            }
        }



        $data['status'] = 'pending';


        $application = VisaApplication::create($data);


        return response()->json([

            'status' => true,

            'message' => 'Visa application submitted successfully',

            'data' => $application->load('visaType.country'),

        ], 201);
    }



    public function show(int $id): JsonResponse
    {
        $application = VisaApplication::with('visaType.country')
            ->find($id);


        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Application not found'
            ], 404);
        }


        return response()->json([
            'status' => true,
            'data' => $application
        ]);
    }



    public function updateStatus(Request $request, int $id): JsonResponse
    {

        $application = VisaApplication::find($id);


        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Application not found'
            ], 404);
        }


        $validated = $request->validate([

            'status' => 'required|in:pending,processing,approved,rejected',

            'remarks' => 'nullable|string',

        ]);


        $application->update($validated);


        return response()->json([
            'status' => true,
            'data' => $application
        ]);
    }



    public function destroy(int $id): JsonResponse
    {

        $application = VisaApplication::find($id);


        if (!$application) {

            return response()->json([
                'status' => false,
                'message' => 'Application not found'
            ], 404);
        }


        $application->delete();


        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}
