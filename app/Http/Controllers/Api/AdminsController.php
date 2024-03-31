<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get("user");
        Admins::where('admins', $user);
        $admin = new Admins();
        $admin->status = "admin";
        return $admin;
    }
}
