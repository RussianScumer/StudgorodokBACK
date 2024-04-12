<?php

namespace App\Http\Controllers\Api;

use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CanteenController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        return Canteen::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    //	title+	type+	price+	img+
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $canteen = new Canteen();
            $canteen->title = $request->get("title");
            $canteen->price = $request->get("price");
            $canteen->type = $request->get("type");
            $canteen->img = $request->get("img");
            $canteen->setImage($canteen, $request);
            $canteen->save();
            return response()->json(['status' => 'success']);
        }
        catch (\Exception) {
            return response()->json(['status' => 'fail'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $canteen = Canteen::find($id);
            $canteen->title = $request->get("title");
            $canteen->price = $request->get("price");
            $canteen->type = $request->get("type");
            if ($request->get("img") != "unchanged") {
                if (!empty($canteen->img)) {
                    $canteen->deleteImage($canteen);
                }
                $canteen->img = $request->get("img");
                $canteen->setImage($canteen, $request);
            }
            $canteen->save();
            return response()->json(['status' => 'success']);
        }
        catch (\Exception) {
            return response()->json(['status' => 'fail'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $canteen = Canteen::find($id);
        if ($canteen) {
            if (!empty($canteen->img)) {
                $canteen->deleteImage($canteen);
            }
            $canteen->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'Dish successfully deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Dish not found'], 404);
        }
    }
}
