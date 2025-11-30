<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderHero;
use Illuminate\Http\Request;

class OrderHeroController extends Controller
{
    public function index()
    {
        $hero = OrderHero::first();
        return view('admin.order-hero.index', compact('hero'));
    }

    public function create()
    {
        return view('admin.order-hero.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('hero', 'public');

        OrderHero::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect()->route('admin.orderhero.index')->with('success', 'Hero Image Added');
    }

    public function edit(OrderHero $orderHero)
    {
        return view('admin.order-hero.edit', compact('orderHero'));
    }

    public function update(Request $request, OrderHero $orderHero)
    {
        $request->validate([
            'title' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $data = ['title' => $request->title];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero', 'public');
        }

        $orderHero->update($data);

        return redirect()->route('admin.orderhero.index')->with('success', 'Updated Successfully');
    }
}

