<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SwatchRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SwatchRequestController extends Controller
{
    // Get all swatch requests (admin)
    public function index(Request $request)
    {
        return SwatchRequest::with('product')->latest()->get();
    }

    // Get requests of logged-in user
    public function userRequests(Request $request)
    {
        $user = $request->user();

        $data = SwatchRequest::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Store a new swatch request
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Validate incoming request
        $data = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'name'          => 'required|string',
            'email'         => 'required|email',
            'phone_country' => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'message'       => 'required|string',
        ]);

        // Attach authenticated user's ID
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        // Create swatch request
        $swatch = SwatchRequest::create($data);
        $swatch->load('product');

        // Save product metadata
        $swatch->product_code = $swatch->product->code;
        $swatch->product_name = $swatch->product->name;
        $swatch->save();

        // Send email notification
        Mail::send('emails.swatch-request', ['swatch' => $swatch], function ($m) use ($swatch) {
            $m->to('devmusa@arbellafashion.com')->subject('Swatch Request');
        });

        return response()->json([
            'success' => true,
            'message' => 'Swatch request sent!',
            'data'    => $swatch
        ]);
    }
}
