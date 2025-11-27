<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomRequestAdminController extends Controller
{
    // Show all custom requests
    public function index()
    {
        $requests = CustomRequest::with('product')->latest()->paginate(10);
        return view('admin.custom-requests.index', compact('requests'));
    }
    public function bulkDelete(Request $request)
    {
        // Validate that IDs exist
        if ($request->filled('ids')) {
            // Convert comma-separated string "1,2,3" to array [1, 2, 3]
            $ids = explode(',', $request->ids);

            // Delete the records
            CustomRequest::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected requests deleted successfully.');
        }

        return back()->with('error', 'No items selected.');
    }
    // Show single request details
    public function show($id)
    {
        $custom = CustomRequest::findOrFail($id);
        return view('admin.custom-requests.show', compact('custom'));
    }

    // Update status (AJAX or form)
    public function updateStatus(Request $request, $id)
    {
        $custom = CustomRequest::findOrFail($id);
        $custom->status = $request->status;
        $custom->save();

        return back()->with('success', 'Status updated successfully!');
    }

    // Delete request
    public function destroy($id)
    {
        $custom = CustomRequest::findOrFail($id);

        if ($custom->attachment) {
            Storage::disk('public')->delete($custom->attachment);
        }

        $custom->delete();

        return back()->with('success', 'Request deleted!');
    }
}
