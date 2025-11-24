<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunitySection;
use Illuminate\Support\Facades\Storage;

class CommunitySectionController extends Controller
{
    // Admin Index Page
    public function index()
    {
        $sections = CommunitySection::all();
        return view('admin.community.index', compact('sections'));
    }

    // Create Form
    public function create()
    {
        return view('admin.community.create');
    }

    // Store new image(s)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:hero,employees,gallery',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $paths = [];

        foreach ($request->file('images') as $image) {
            $paths[] = $image->store('community', 'public');
        }

        // if hero or employees, remove old and keep one record
        if (in_array($request->type, ['hero', 'employees'])) {
            $existing = CommunitySection::where('type', $request->type)->first();
            if ($existing) {
                foreach ($existing->images ?? [] as $old) {
                    Storage::disk('public')->delete($old);
                }
                $existing->delete();
            }
        }

        CommunitySection::create([
            'type' => $request->type,
            'images' => $paths,
        ]);

        return redirect()->route('admin.community.index')->with('success', 'Images uploaded successfully!');
    }

    // Edit
    public function edit($id)
    {
        $section = CommunitySection::findOrFail($id);
        return view('admin.community.edit', compact('section'));
    }

    // Update images
    public function update(Request $request, $id)
    {
        $section = CommunitySection::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($section->images ?? [] as $old) {
                Storage::disk('public')->delete($old);
            }

            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('community', 'public');
            }

            $section->images = $paths;
            $section->save();
        }

        return redirect()->route('admin.community.index')->with('success', 'Images updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        $section = CommunitySection::findOrFail($id);
        foreach ($section->images ?? [] as $img) {
            Storage::disk('public')->delete($img);
        }
        $section->delete();

        return redirect()->back()->with('success', 'Section deleted.');
    }

    // API endpoint
    public function apiIndex()
    {
        $sections = CommunitySection::all();

        $data = [
            'hero' => null,
            'employees' => null,
            'gallery' => [],
        ];

        foreach ($sections as $section) {
            $urls = array_map(fn($i) => asset('storage/' . $i), $section->images ?? []);
            if ($section->type === 'hero') $data['hero'] = $urls[0] ?? null;
            elseif ($section->type === 'employees') $data['employees'] = $urls[0] ?? null;
            elseif ($section->type === 'gallery') $data['gallery'] = array_merge($data['gallery'], $urls);
        }

        return response()->json($data);
    }
}
