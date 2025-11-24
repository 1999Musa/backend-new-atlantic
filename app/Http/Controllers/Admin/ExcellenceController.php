<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExcellenceSection;
use Illuminate\Support\Facades\Storage;

class ExcellenceController extends Controller
{
    // Show all sections
    public function index()
    {
        $sections = ExcellenceSection::all();
        return view('admin.excellence.index', compact('sections'));
    }

    // Show create/upload view
    public function create()
    {
        $sections = ExcellenceSection::all();
        return view('admin.excellence.create', compact('sections'));
    }

    // Store uploaded images
    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'section_id' => 'required|exists:excellence_sections,id',
        ]);

        $section = ExcellenceSection::findOrFail($request->section_id);

        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('excellence', 'public');
                $uploadedImages[] = $path;
            }
        }

        $section->images = array_merge($section->images ?? [], $uploadedImages);
        $section->save();

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    // Edit section
    public function edit($id)
    {
        $section = ExcellenceSection::findOrFail($id);
        return view('admin.excellence.edit', compact('section'));
    }

    // Update section (add/remove images)
    public function update(Request $request, $id)
    {
        $section = ExcellenceSection::findOrFail($id);
        $images = $section->images ?? [];

        // ✅ Remove selected checkboxes
        if ($request->filled('remove_images')) {
            foreach ($request->remove_images as $imgPath) {
                if (in_array($imgPath, $images)) {
                    Storage::disk('public')->delete($imgPath);
                    $images = array_filter($images, fn($img) => $img !== $imgPath);
                }
            }
            $images = array_values($images);
        }

        // ✅ Upload new images
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            foreach ($request->file('images') as $image) {
                $path = $image->store('excellence', 'public');
                $images[] = $path;
            }
        }

        $section->images = array_values($images);
        $section->save();

        return redirect()->back()->with('success', 'Section updated successfully!');
    }

    // ✅ AJAX remove image (instant delete)
public function removeImage(Request $request, $id)
{
    $section = ExcellenceSection::findOrFail($id);
    $imagePath = $request->input('image');

    if (!$imagePath) {
        return response()->json(['success' => false, 'message' => 'No image path provided.']);
    }

    $images = $section->images ?? [];

    if (in_array($imagePath, $images)) {
        Storage::disk('public')->delete($imagePath);
        $images = array_values(array_filter($images, fn($img) => $img !== $imagePath));
        $section->images = $images;
        $section->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Image not found in this section.']);
}



    // API for React
    public function apiIndex()
    {
        $sections = ExcellenceSection::all();

        $data = $sections->map(function ($section) {
            return [
                'title' => $section->title,
                'images' => array_map(fn($img) => asset('storage/' . $img), $section->images ?? []),
            ];
        });

        return response()->json($data);
    }
}
