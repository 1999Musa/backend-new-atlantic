<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserBag;
use App\Models\Product;

class BagController extends Controller
{
    // Add item to bag
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = $request->user();

        // prevent duplicates
        $exists = UserBag::where('user_id', $user->id)
                         ->where('product_id', $request->product_id)
                         ->first();

        if ($exists) {
            return response()->json([
                'success' => true,
                'message' => 'Product already in your bag'
            ]);
        }

        UserBag::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to bag'
        ]);
    }

    // Remove item
   public function remove(Request $request, $bag_id)
{
    $user = $request->user();

    UserBag::where('id', $bag_id)
           ->where('user_id', $user->id)
           ->delete();

    return response()->json([
        'success' => true,
        'message' => 'Removed from bag'
    ]);
}


    // List items in bag
    public function list(Request $request)
{
    $user = $request->user();

    $items = UserBag::where('user_id', $user->id)
        ->with(['product' => function ($q) {
            $q->select('id', 'name', 'price', 'discounted_price', 'product_code')
              ->with('images');
        }])
        ->get();

    return response()->json([
        'success' => true,
        'bag' => $items
    ]);
}

}
