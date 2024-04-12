<?php

namespace App\Http\Controllers\Api;

use App\Models\Admins;
use Http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->get("user");
        if (Admins::where("users", $user)->exists()) {
            return response()->json(['status' => 'admin']);
        }
        else {
            return response()->json(['status' => 'user']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admins $admins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admins $admins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admins $admins)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admins $admins)
    {
        //
    }
}
