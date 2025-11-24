<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutHeroController extends Controller
{
    // Admin view - index
    public function index()
    {
        $heroes = AboutHero::all();
        return view('admin.about_hero.index', compact('heroes'));
    }

    // Admin view - create form
    public function create()
    {
        return view('admin.about_hero.create');
    }

    // Store hero data
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'video' => 'nullable|file|mimes:mp4,webm',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero_sliders', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('hero_videos', 'public');
        }

        AboutHero::create($data);

        return redirect()->route('admin.about-hero.index')->with('success', 'Hero added successfully!');
    }

    // Edit hero
    public function edit(AboutHero $aboutHero)
    {
        return view('admin.about_hero.edit', compact('aboutHero'));
    }

    // Update hero
    public function update(Request $request, AboutHero $aboutHero)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'video' => 'nullable|file|mimes:mp4,webm',
        ]);

        if ($request->hasFile('image')) {
            if ($aboutHero->image) {
                Storage::disk('public')->delete($aboutHero->image);
            }
            $data['image'] = $request->file('image')->store('hero_sliders', 'public');
        }

        if ($request->hasFile('video')) {
            if ($aboutHero->video) {
                Storage::disk('public')->delete($aboutHero->video);
            }
            $data['video'] = $request->file('video')->store('hero_videos', 'public');
        }

        $aboutHero->update($data);

        return redirect()->route('admin.about-hero.index')->with('success', 'Hero updated successfully!');
    }

    // Delete
    public function destroy(AboutHero $aboutHero)
    {
        if ($aboutHero->image) {
            Storage::disk('public')->delete($aboutHero->image);
        }
        if ($aboutHero->video) {
            Storage::disk('public')->delete($aboutHero->video);
        }

        $aboutHero->delete();
        return redirect()->back()->with('success', 'Hero deleted successfully!');
    }

    // API endpoint for React
    public function apiIndex()
    {
        $hero = AboutHero::latest()->first();
        if ($hero) {
            $hero->image = $hero->image ? asset('storage/' . $hero->image) : null;
            $hero->video = $hero->video ? asset('storage/' . $hero->video) : null;
        }
        return response()->json($hero);
    }
}
