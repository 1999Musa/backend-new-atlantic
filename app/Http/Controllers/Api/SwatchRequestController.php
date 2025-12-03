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
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_country' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'message' => 'required|string',
        ]);
        
        $data['status'] = 'pending';

        $swatch = SwatchRequest::create($data);
        $swatch->load('product');

        $swatch->product_code = $swatch->product->code;
        $swatch->product_name = $swatch->product->name;
        $swatch->save(); // 🔥 IMPORTANT


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

    public function userRequests(Request $request)
    {
        $email = $request->user()->email; // logged-in user

        $data = SwatchRequest::with('product')
            ->where('email', $email)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

}
