<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    // API for React
public function apiIndex()
{
    $logo = Logo::latest()->first();

    if (!$logo || !$logo->image) {
        return response()->json(['logo_url' => null]);
    }

    return response()->json([
        'logo_url' => asset('storage/' . $logo->image)
    ]);
}


    // Admin index
    public function index()
    {
        $logos = Logo::all();
        return view('admin.logo.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.logo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('logos', 'public');
        }

        Logo::create($data);

        return redirect()->route('admin.logo.index')->with('success', 'Logo uploaded successfully');
    }

    public function edit(Logo $logo)
    {
        return view('admin.logo.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp |max:40960',
        ]);

        if ($request->hasFile('image')) {
            // delete old
            if ($logo->image) {
                Storage::disk('public')->delete($logo->image);
            }
            $data['image'] = $request->file('image')->store('logos', 'public');
        }

        $logo->update($data);

        return redirect()->route('admin.logo.index')->with('success', 'Logo updated successfully');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->image) {
            Storage::disk('public')->delete($logo->image);
        }
        $logo->delete();

        return redirect()->route('admin.logo.index')->with('success', 'Logo deleted successfully');
    }

    public function removeImage(Logo $logo)
    {
        if ($logo->image) {
            Storage::disk('public')->delete($logo->image);
            $logo->update(['image' => null]);
        }

        return response()->json(['success' => true]);
    }
}
