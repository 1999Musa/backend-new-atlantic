<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlaceOrderItem;
use Illuminate\Http\Request;

class PlaceOrderItemController extends Controller
{
    // Admin index
    public function index() {
        $items = PlaceOrderItem::all();
        return view('admin.place_order.index', compact('items'));
    }

    public function create() {
        return view('admin.place_order.create');
    }

    public function store(Request $request) {
    $data = $request->validate([
        'type' => 'required|in:step,info,reason',
        'step' => 'nullable|string',
        'title' => 'required|string',
        'description' => 'nullable|string',
        'list_items' => 'nullable',
    ]);

    // Handle list_items (textarea input or array input)
    if ($request->filled('list_items')) {
        if (is_array($request->list_items)) {
            $data['list_items'] = json_encode($request->list_items);
        } else {
            $data['list_items'] = json_encode(array_filter(explode("\n", $request->list_items)));
        }
    }

    PlaceOrderItem::create($data);

    return redirect()->route('admin.place-order.index')->with('success', 'Item created');
}


    public function edit(PlaceOrderItem $place_order) {
    return view('admin.place_order.edit', ['item' => $place_order]);
}

public function update(Request $request, PlaceOrderItem $place_order) {
    $data = $request->validate([
        'type' => 'required|string|in:step,info,reason',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'list_items' => 'nullable',
    ]);

    if ($request->filled('list_items')) {
        if (is_array($request->list_items)) {
            $data['list_items'] = json_encode($request->list_items);
        } else {
            $data['list_items'] = json_encode(array_filter(explode("\n", $request->list_items)));
        }
    }

    $place_order->update($data);

    return redirect()->route('admin.place-order.index')->with('success', 'Updated successfully.');
}




    public function destroy(PlaceOrderItem $place_order_item) {
        $place_order_item->delete();
        return back()->with('success','Item deleted');
    }

    // API endpoint for React
    public function apiIndex() {
        return response()->json([
            'steps' => PlaceOrderItem::where('type','step')->get(),
            'importantInfos' => PlaceOrderItem::where('type','info')->get(),
            'reasons' => PlaceOrderItem::where('type','reason')->get(),
        ]);
    }
}

