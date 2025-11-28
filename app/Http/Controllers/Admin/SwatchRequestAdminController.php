<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SwatchRequest;
use Illuminate\Http\Request;

class SwatchRequestAdminController extends Controller
{
    public function index()
    {
        $swatches = SwatchRequest::with('product')->latest()->paginate(20);
        return view('admin.swatch.index', compact('swatches'));
    }

    // public function updateStatus(Request $request, SwatchRequest $swatch)
    // {
    //     $request->validate(['status' => 'required|in:pending,approved,delivered']);
    //     $swatch->update(['status' => $request->status]);
    //     return back()->with('success', 'Status updated');
    // }
    // 🔹 NEW: Show Single Detail
    public function show($id)
    {
        $swatch = SwatchRequest::with('product')->findOrFail($id);
        return view('admin.swatch.show', compact('swatch'));
    }

    public function updateStatus(Request $request, $id)
    {
        $swatch = SwatchRequest::findOrFail($id);
        $swatch->update(['status' => $request->status]);
        return back()->with('success', 'Status updated successfully');
    }

    // 🔹 NEW: Delete Single
    public function destroy($id)
    {
        SwatchRequest::findOrFail($id)->delete();
        return back()->with('success', 'Request deleted successfully');
    }

    // 🔹 NEW: Bulk Delete
    public function bulkDelete(Request $request)
    {
        if ($request->filled('ids')) {
            $ids = explode(',', $request->ids);
            SwatchRequest::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected items deleted.');
        }
        return back()->with('error', 'No items selected.');
    }
}
