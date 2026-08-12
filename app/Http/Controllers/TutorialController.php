<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::latest()->get();
        $trashedCount = Tutorial::onlyTrashed()->count();
        return view('tutorial.index', compact('tutorials', 'trashedCount'));
    }

    public function create()
    {
        return view('tutorial.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'category'    => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive',
        ]);

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

        Tutorial::create($data);

        return redirect()->route('tutorial.index')->with('success', 'Tutorial created successfully.');
    }

    public function edit($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        return view('tutorial.edit', compact('tutorial'));
    }

    public function update(Request $request, $id)
    {
        $tutorial = Tutorial::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:500',
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
            'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'category'    => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive',
        ]);

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

        return redirect()->route('tutorial.index')->with('success', 'Tutorial updated successfully.');
    }

    public function destroy($id)
    {
        Tutorial::findOrFail($id)->delete();
        return back()->with('success', 'Tutorial moved to trash.');
    }

    public function trash()
    {
        $tutorials = Tutorial::onlyTrashed()->latest()->get();
        return view('tutorial.trash', compact('tutorials'));
    }

    public function restore($id)
    {
        Tutorial::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Tutorial restored successfully.');
    }
}
