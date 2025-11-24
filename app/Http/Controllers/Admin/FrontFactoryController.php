<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontFactory;
use Illuminate\Http\Request;

class FrontFactoryController extends Controller
{
    // Admin Views
    public function index()
    {
        $factories = FrontFactory::latest()->get();
        return view('admin.front-factory.index', compact('factories'));
    }

    public function create()
    {
        return view('admin.front-factory.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('factory', 'public');
        }

        FrontFactory::create($data);

        return redirect()->route('admin.front-factory.index')->with('success', 'Factory image added.');
    }

    public function edit(FrontFactory $frontFactory)
    {
        return view('admin.front-factory.edit', compact('frontFactory'));
    }

    public function update(Request $request, FrontFactory $frontFactory)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('factory', 'public');
        }

        $frontFactory->update($data);

        return redirect()->route('admin.front-factory.index')->with('success', 'Factory image updated.');
    }

    public function destroy(FrontFactory $frontFactory)
    {
        $frontFactory->delete();
        return redirect()->route('admin.front-factory.index')->with('success', 'Factory image removed.');
    }

    // API for React
    public function apiIndex()
    {
        $factory = FrontFactory::latest()->first();
        return response()->json($factory);
    }
}
