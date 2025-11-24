<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sustainability;
use Illuminate\Support\Facades\Storage;

class SustainabilityController extends Controller
{
    // For API (React)
    public function apiIndex()
    {
        $sustainabilities = Sustainability::all();
        return response()->json($sustainabilities);
    }

    // Admin index
    public function index()
    {
        $sustainabilities = Sustainability::all();
        return view('admin.sustainability.index', compact('sustainabilities'));
    }

    public function create()
    {
        return view('admin.sustainability.create');
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp |max:40960',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('sustainability', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sustainability', 'public');
        }

        Sustainability::create($data);

        return redirect()->route('admin.sustainability.index')->with('success', 'Sustainability pillar created');
    }

    public function edit(Sustainability $sustainability)
    {
        return view('admin.sustainability.edit', compact('sustainability'));
    }

public function update(Request $request, Sustainability $sustainability)
{
    $data = $request->validate([
        'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'description' => 'nullable|string',
    ]);

    // Replace hero image if new one is uploaded
    if ($request->hasFile('hero_image')) {
        if ($sustainability->hero_image) {
            Storage::disk('public')->delete($sustainability->hero_image);
        }
        $data['hero_image'] = $request->file('hero_image')->store('sustainability', 'public');
    }

    // Replace pillar image if new one is uploaded
    if ($request->hasFile('image')) {
        if ($sustainability->image) {
            Storage::disk('public')->delete($sustainability->image);
        }
        $data['image'] = $request->file('image')->store('sustainability', 'public');
    }

    $sustainability->update($data);

    return redirect()->route('admin.sustainability.index')->with('success', 'Updated successfully');
}


    public function destroy(Sustainability $sustainability)
    {
        $sustainability->delete();
        return redirect()->route('admin.sustainability.index')->with('success', 'Deleted successfully');
    }
    public function removeHeroImage(Sustainability $sustainability)
{
    if ($sustainability->hero_image) {
        Storage::disk('public')->delete($sustainability->hero_image);
        $sustainability->update(['hero_image' => null]);
    }
    return response()->json(['success' => true]);
}

public function removePillarImage(Sustainability $sustainability)
{
    if ($sustainability->image) {
        Storage::disk('public')->delete($sustainability->image);
        $sustainability->update(['image' => null]);
    }
    return response()->json(['success' => true]);
}

}
