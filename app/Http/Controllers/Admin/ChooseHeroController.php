<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chooseimg;

class ChooseHeroController extends Controller
{
    // Show list in admin
    public function index()
    {
        $image = Chooseimg::latest()->first();
        return view('admin.chooseimg.index', compact('image'));
    }

    // Show create form
    public function create()
    {
        return view('admin.chooseimg.create');
    }

    // Store new image
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4000',
        ]);

        $path = $request->file('image')->store('hero_sliders', 'public');

        Chooseimg::create([
            'image' => $path,
        ]);

        return redirect()->route('admin.chooseimg.index')->with('success', 'Hero image uploaded successfully!');
    }

    // Show edit form
    public function edit(Chooseimg $chooseimg)
    {
        return view('admin.chooseimg.edit', compact('chooseimg'));
    }

    // Update
    public function update(Request $request, Chooseimg $chooseimg)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4000',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero_sliders', 'public');
            $chooseimg->update(['image' => $path]);
        }

        return redirect()->route('admin.chooseimg.index')->with('success', 'Hero image updated successfully!');
    }

    // API Endpoint
    public function apiIndex()
    {
        $image = Chooseimg::latest()->first();
        if ($image) {
            $image->image = asset('storage/' . $image->image);
        }
        return response()->json($image);
    }
}
