<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactHero;
use Illuminate\Support\Facades\Storage;

class ContactHeroController extends Controller
{
    // Admin index page
    public function index()
    {
        $hero = ContactHero::first();
        return view('admin.contacthero.index', compact('hero'));
    }

    // Create new
    public function create()
    {
        return view('admin.contacthero.create');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('image')->store('contacthero', 'public');

        // Keep only one record
        ContactHero::truncate();

        ContactHero::create(['image' => $path]);

        return redirect()->route('admin.contacthero.index')->with('success', 'Contact Hero Image Uploaded!');
    }

    // Edit
    public function edit($id)
    {
        $hero = ContactHero::findOrFail($id);
        return view('admin.contacthero.edit', compact('hero'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $hero = ContactHero::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($hero->image);
            $path = $request->file('image')->store('contacthero', 'public');
            $hero->update(['image' => $path]);
        }

        return redirect()->route('admin.contacthero.index')->with('success', 'Contact Hero Image Updated!');
    }

    // Delete
    public function destroy($id)
    {
        $hero = ContactHero::findOrFail($id);
        Storage::disk('public')->delete($hero->image);
        $hero->delete();
        return redirect()->back()->with('success', 'Hero Image Deleted.');
    }

    // API Endpoint
    public function apiIndex()
    {
        $hero = ContactHero::first();
        return response()->json([
            'image' => $hero ? asset('storage/' . $hero->image) : null,
        ]);
    }
}
