<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertifiedLogo;
use Illuminate\Http\Request;

class CertifiedLogoController extends Controller
{
    // Admin Views
    public function index()
    {
        $logos = CertifiedLogo::latest()->get();
        return view('admin.certified-logos.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.certified-logos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certified_logos', 'public');
        }

        CertifiedLogo::create($data);

        return redirect()->route('admin.certified-logos.index')->with('success', 'Logo added successfully.');
    }

    public function edit(CertifiedLogo $certifiedLogo)
    {
        return view('admin.certified-logos.edit', compact('certifiedLogo'));
    }

    public function update(Request $request, CertifiedLogo $certifiedLogo)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certified_logos', 'public');
        }

        $certifiedLogo->update($data);

        return redirect()->route('admin.certified-logos.index')->with('success', 'Logo updated successfully.');
    }

    public function destroy(CertifiedLogo $certifiedLogo)
    {
        $certifiedLogo->delete();
        return redirect()->route('admin.certified-logos.index')->with('success', 'Logo deleted successfully.');
    }

    // API for React
    public function apiIndex()
    {
        $logos = CertifiedLogo::latest()->get()->map(function($logo){
            return [
                'id' => $logo->id,
                'title' => $logo->title,
                'image' => asset('storage/'.$logo->image),
            ];
        });
        return response()->json($logos, 200);
    }
}
