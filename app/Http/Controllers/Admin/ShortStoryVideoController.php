<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortStoryVideo;
use Illuminate\Http\Request;

class ShortStoryVideoController extends Controller
{
    // Admin Views
    public function index()
    {
        $videos = ShortStoryVideo::latest()->get();
        return view('admin.short-story.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.short-story.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,webm|max:51200' // 50MB max
        ]);

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('short_story_videos', 'public');
        }

        ShortStoryVideo::create($data);

        return redirect()->route('admin.short-story.index')->with('success', 'Video added successfully.');
    }

    public function edit(ShortStoryVideo $shortStoryVideo)
    {
        return view('admin.short-story.edit', compact('shortStoryVideo'));
    }

    public function update(Request $request, ShortStoryVideo $shortStoryVideo)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,webm|max:51200'
        ]);

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('short_story_videos', 'public');
        }

        $shortStoryVideo->update($data);

        return redirect()->route('admin.short-story.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(ShortStoryVideo $shortStoryVideo)
    {
        $shortStoryVideo->delete();
        return redirect()->route('admin.short-story.index')->with('success', 'Video deleted successfully.');
    }

    // API for React
    public function apiIndex()
    {
        $video = ShortStoryVideo::latest()->first();
        if ($video) {
            $video->video = $video->video ? asset('storage/'.$video->video) : null;
        }
        return response()->json($video, 200);
    }
}
