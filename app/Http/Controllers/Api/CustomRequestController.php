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


public function index(Request $request)
{
   $user = $request->user();


    if (!$user) {
        return response()->json(["success" => false, "message" => "Unauthorized"], 401);
    }

    $requests = CustomRequest::with('product')
        ->where('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($req) {
            return [
                'id' => $req->id,
                'product_code' => $req->product->product_code ?? 'N/A',
                'product_name' => $req->product->name ?? 'N/A',
                'created_at' => $req->created_at,
                'status' => $req->status,
                'quantity' => $req->quantity ?? 1, // optional
            ];
        });

    return response()->json([
        "success" => true,
        "data" => $requests
    ]);
}




    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'   => 'required|integer',
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone_country'=> 'required|string',
            'phone_number' => 'required|string',
            'quantity'     => 'required|integer',
            'message'      => 'required|string',
            'attachment'   => 'nullable|file|max:5120',
        ]);

        // Save file
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')
                ->store('custom-requests', 'public');
        }

        // Store in DB
        $custom = CustomRequest::create($data);

        // Send Email
        Mail::send('emails.custom-request', ['custom' => $custom], function ($m) use ($custom) {
            $m->to('devmusa@arbellafashion.com', 'Admin')
              ->subject('New Customization Request');

            if ($custom->attachment) {
                $m->attach(Storage::disk('public')->path($custom->attachment));
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Customization request sent successfully',
        ]);
    }
}

