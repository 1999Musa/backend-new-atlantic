<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FactoryController extends Controller
{
    public function index()
    {
        $factories = Factory::all();
        return view('admin.factory.index', compact('factories'));
    }

    public function create()
    {
        return view('admin.factory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'gallery.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'certificates.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'clients.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
        ]);

        $data = [];

        // Hero
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')->store('factory', 'public');
        }

        // Multi-file groups
        foreach (['gallery', 'certificates', 'clients'] as $field) {
            $items = [];
            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $f) {
                    $items[] = $f->store('factory', 'public');
                }
            }
            // only set the key if there are items
            if (!empty($items)) {
                $data[$field] = $items;
            }
        }

        Factory::create($data);

        return redirect()->route('admin.factory.index')->with('success', 'Factory created!');
    }

    public function edit(Factory $factory)
    {
        return view('admin.factory.edit', compact('factory'));
    }

    public function update(Request $request, Factory $factory)
    {
        $request->validate([
            'hero_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'gallery.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'certificates.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'clients.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:40960',
            'remove_gallery' => 'nullable|array',
            'remove_certificates' => 'nullable|array',
            'remove_clients' => 'nullable|array',
        ]);

        $data = [];

        // Replace hero image if uploaded (and delete old)
        if ($request->hasFile('hero_image')) {
            // delete old hero if exists
            if ($factory->hero_image && Storage::disk('public')->exists($factory->hero_image)) {
                Storage::disk('public')->delete($factory->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('factory', 'public');
        }

        // For each multi-file field handle removals & additions
        foreach (['gallery', 'certificates', 'clients'] as $field) {
            // start with existing (ensure array)
            $existing = is_array($factory->$field) ? $factory->$field : [];

            // remove selected indexes (we used indexes in edit view)
            $removeKey = 'remove_' . $field;
            $toRemove = $request->input($removeKey, []); // array of indexes (strings)
            if (!empty($toRemove) && is_array($toRemove)) {
                // sort descending to safely unset by integer index
                $indexes = array_map('intval', $toRemove);
                rsort($indexes);
                foreach ($indexes as $idx) {
                    if (isset($existing[$idx])) {
                        // delete file physically
                        if (Storage::disk('public')->exists($existing[$idx])) {
                            Storage::disk('public')->delete($existing[$idx]);
                        }
                        unset($existing[$idx]);
                    }
                }
                // reindex
                $existing = array_values($existing);
            }

            // add newly uploaded files (append)
            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $f) {
                    $existing[] = $f->store('factory', 'public');
                }
            }

            // set value (even if empty array)
            $data[$field] = $existing;
        }

        $factory->update($data);

        return redirect()->route('admin.factory.index')->with('success', 'Factory updated!');
    }

    public function destroy(Factory $factory)
    {
        // delete files
        if ($factory->hero_image && Storage::disk('public')->exists($factory->hero_image)) {
            Storage::disk('public')->delete($factory->hero_image);
        }
        foreach (['gallery','certificates','clients'] as $field) {
            if (is_array($factory->$field)) {
                foreach ($factory->$field as $p) {
                    if (Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
            }
        }
        $factory->delete();
        return back()->with('success','Deleted!');
    }

    // API for React
    public function apiIndex()
    {
        $factory = Factory::first();

        if (!$factory) {
            return response()->json([
                'heroImage' => null,
                'gallery' => [],
                'certificates' => [],
                'clients' => [],
            ]);
        }

        return response()->json([
            'heroImage' => $factory->hero_image ? asset('storage/' . $factory->hero_image) : null,
            'gallery' => is_array($factory->gallery) ? array_map(fn($img) => asset('storage/' . $img), $factory->gallery) : [],
            'certificates' => is_array($factory->certificates) ? array_map(fn($img) => asset('storage/' . $img), $factory->certificates) : [],
            'clients' => is_array($factory->clients) ? array_map(fn($img) => asset('storage/' . $img), $factory->clients) : [],
        ]);
    }
}
