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

    public function updateStatus(Request $request, SwatchRequest $swatch)
    {
        $request->validate(['status' => 'required|in:pending,approved,delivered']);
        $swatch->update(['status' => $request->status]);
        return back()->with('success', 'Status updated');
    }
}
