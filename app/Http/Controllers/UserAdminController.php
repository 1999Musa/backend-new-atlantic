<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = UserLogin::latest()->get();
        return view('admin.users.index', compact('users'));
    }
}
