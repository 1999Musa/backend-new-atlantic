<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SwatchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SwatchRequestController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'product_id'    => 'required|exists:products,id', // Validate product exists
        'name'          => 'required|string',
        'email'         => 'required|email',
        'phone_country' => 'required|string',
        'phone_number'  => 'required|string',
        'address'       => 'required|string',
        'message'       => 'required|string',
    ]);

    $swatch = SwatchRequest::create($data);

    // Load product relationship so it's available in the email view
    $swatch->load('product');

    // Send Email
    Mail::send('emails.swatch-request', ['swatch' => $swatch], function ($m) use ($swatch) {
        $m->to('devmusa@arbellafashion.com', 'Admin')
          ->subject('New Fabric Swatch Request - ' . ($swatch->product->product_code ?? 'N/A'));
    });

    return response()->json([
        'success' => true,
        'message' => 'Swatch request sent successfully!',
    ]);
}
}