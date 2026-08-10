<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:51200',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
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

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('tutorials/thumbnails', 'public');
        }

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('tutorials/videos', 'public');
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
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:51200',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
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

        if ($request->hasFile('thumbnail')) {
            if ($tutorial->thumbnail && Storage::disk('public')->exists($tutorial->thumbnail)) {
                Storage::disk('public')->delete($tutorial->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('tutorials/thumbnails', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($tutorial->video_file && Storage::disk('public')->exists($tutorial->video_file)) {
                Storage::disk('public')->delete($tutorial->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('tutorials/videos', 'public');
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
