<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SwatchRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class SwatchRequestController extends Controller
{
    // List all swatch requests (for admin)
    public function index(Request $request)
    {
        return SwatchRequest::with('product')
            ->latest()
            ->get();
    }

    // Store a new swatch request
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone_country'=> 'required|string',
            'phone_number' => 'required|string',
            'address'      => 'required|string',
            'message'      => 'required|string',
        ]);

        $data['status'] = 'pending';

        // Save to database
        $swatch = SwatchRequest::create($data);
        $swatch->load('product');

        // Send email
        \Mail::send('emails.swatch-request', [
            'swatch' => $swatch
        ], function ($m) use ($swatch) {
            $m->to('devmusa@arbellafashion.com', 'Admin')
              ->subject('Fabric Swatch Request - ' . ($swatch->product->product_code ?? 'N/A'));
        });

        return response()->json([
            'success' => true,
            'message' => 'Swatch request sent!',
            'data' => $swatch
        ]);
    }

    // 🟦 USER REQUEST FETCHER (for dashboard)
public function userRequests(Request $request)
{
    $user = $request->user(); // middleware attaches this

    if (!$user) {
        return response()->json(["success" => false, "message" => "Unauthorized"], 401);
    }

    $requests = SwatchRequest::with('product')
        ->where('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(fn($req) => [
            'id' => $req->id,
            'product_code' => $req->product->product_code ?? 'N/A',
            'product_name' => $req->product->name ?? 'N/A',
            'created_at' => $req->created_at->toDateTimeString(),
            'status' => $req->status,
        ]);

    return response()->json([
        "success" => true,
        "data" => $requests
    ]);
}



}
