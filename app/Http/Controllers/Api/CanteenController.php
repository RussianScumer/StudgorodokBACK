<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Barter;
use App\Models\Canteen;
use App\Models\News;
use Illuminate\Http\Request;

class CanteenController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Canteen::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    //	title+	type+	price+	img+
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $canteen = new Canteen();
        $canteen->title = $request->get("title");
        $canteen->price = $request->get("price");
        $canteen->type = $request->get("type");
        $canteen->img = $request->get("img");
        $canteen->setImage($canteen, $request);
        $canteen->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $canteen = Canteen::find($id);
        return response()->json(['status' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $canteen = Canteen::find($id);
        $canteen->title = $request->get("title");
        $canteen->price = $request->get("price");
        $canteen->type = $request->get("type");
        if ($request->get("img") != "unchanged") {
            $canteen->deleteImage($canteen);
            // TODO: Удалить старую картинку из storage
            $canteen->img = $request->get("img");
            $canteen->setImage($canteen, $request);
        }
        $canteen->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $user): \Illuminate\Http\JsonResponse
    {
        $canteen = Canteen::find($id);
        if ($canteen) {
            $canteen->forceDelete();
            $canteen->deleteImage($canteen);
            return response()->json(['status' => 'success', 'message' => 'Dish successfully deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Dish not found'], 404);
        }
    }
}
