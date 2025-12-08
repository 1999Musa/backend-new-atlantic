<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomRequest;
use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class CustomRequestController extends Controller
{

public function userRequests(Request $request)
{
    $user = $request->user();

    $data = CustomRequest::with('product')
        ->where('user_id', $user->id)
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

public function store(Request $request)
{
    $user = $request->user();

    $data = $request->validate([
        'product_id' => 'required|integer',
        'name' => 'required|string',
        'email' => 'required|email',
        'phone_country' => 'required|string',
        'phone_number' => 'required|string',
        'quantity' => 'required|integer',
        'message' => 'required|string',
        'attachment' => 'nullable|file|max:5120',
    ]);

    // Attach the logged-in user_id
    $data['user_id'] = $user->id;

    if ($request->hasFile('attachment')) {
        $data['attachment'] = $request->file('attachment')
            ->store('custom-requests', 'public');
    }

    $custom = CustomRequest::create($data);
    $custom->load('product');

    $custom->product_code = $custom->product->code;
    $custom->product_name = $custom->product->name;
    $custom->save();

    // Email
    Mail::send('emails.custom-request', ['custom' => $custom], function ($m) use ($custom) {
        $m->to('devmusa@arbellafashion.com')->subject('New Customization Request');
    });

    return response()->json([
        'success' => true,
        'message' => 'Customization request sent successfully',
    ]);
}

}

