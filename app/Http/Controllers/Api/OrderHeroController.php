<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderHero;

class OrderHeroController extends Controller
{
    public function index()
    {
        return response()->json([
            'hero' => OrderHero::first()
        ]);
    }
}

