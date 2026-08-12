<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TutorialController extends Controller
{
    /**
     * Get list of tutorials (with optional search and category filter).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Tutorial::where('status', 'active')->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tutorials = $query->paginate(20);

        return response()->json([
            'status' => true,
            'data'   => $tutorials
        ]);
    }

    /**
     * Get single tutorial details.
     */
    public function show(int $id): JsonResponse
    {
        $tutorial = Tutorial::find($id);

        if (!$tutorial) {
            return response()->json([
                'status'  => false,
                'message' => 'Tutorial not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $tutorial
        ]);
    }

    /**
     * Create a new tutorial.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'category'    => 'nullable|string|max:100',
            'status'      => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $destinationPath = public_path('uploads/tutorials');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_thumb_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['thumbnail'] = 'uploads/tutorials/' . $filename;
        }

        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_video_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['video_file'] = 'uploads/tutorials/' . $filename;
        }

        $data['status'] = $data['status'] ?? 'active';

        $tutorial = Tutorial::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Tutorial created successfully',
            'data'    => $tutorial
        ], 201);
    }

    /**
     * Update an existing tutorial.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $tutorial = Tutorial::find($id);

        if (!$tutorial) {
            return response()->json([
                'status'  => false,
                'message' => 'Tutorial not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'category'    => 'nullable|string|max:100',
            'status'      => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = array_filter($validator->validated(), fn($value) => !is_null($value));

        $destinationPath = public_path('uploads/tutorials');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_thumb_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['thumbnail'] = 'uploads/tutorials/' . $filename;
        }

        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_video_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['video_file'] = 'uploads/tutorials/' . $filename;
        }

        $tutorial->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Tutorial updated successfully',
            'data'    => $tutorial
        ]);
    }

    /**
     * Delete a tutorial.
     */
    public function destroy(int $id): JsonResponse
    {
        $tutorial = Tutorial::find($id);

        if (!$tutorial) {
            return response()->json([
                'status'  => false,
                'message' => 'Tutorial not found'
            ], 404);
        }

        $tutorial->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Tutorial deleted successfully'
        ]);
    }
}
