<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::all();
        return view('admin.hero_sliders.index', compact('sliders'));

    }

    public function create()
    {
        return view('admin.hero_sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|max:40960',
        ]);

        $data['hero_image'] = $request->file('hero_image')->store('hero_sliders', 'public');


        HeroSlider::create($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Slider added!');
    }

    public function edit(HeroSlider $hero_slider)
    {
        return view('admin.hero_sliders.edit', compact('hero_slider'));
    }

    public function update(Request $request, HeroSlider $hero_slider)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|max:40960',
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('hero_sliders', 'public');
        }

        $hero_slider->update($data);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Slider updated!');
    }

    public function destroy(HeroSlider $hero_slider)
    {
        $hero_slider->delete();
        return back()->with('success', 'Slider deleted!');
    }

    // ✅ API for React
    public function apiIndex()
    {
        $sliders = HeroSlider::all()->map(fn($slider) => [
            'id' => $slider->id,
            'title' => $slider->title,
            'subtitle' => $slider->subtitle,
            'heroImage' => asset('storage/' . $slider->hero_image),
        ]);

        return response()->json($sliders);
    }
}
