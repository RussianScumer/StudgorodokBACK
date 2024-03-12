<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barter;
use App\Models\Canteen;
use App\Models\News;
use Illuminate\Http\Request;

class CanteenController extends Controller{

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
    public function store(Request $request)
    {
        $canteen = new Canteen();
        $canteen->title = $request->get("title");
        $canteen->img = $request->get("img");
        $canteen->setImage($canteen, $request);
        //////////////////////
        $canteen->price = $request->get("price");
        $canteen->type = $request->get("type");

        $canteen->save();
        return "successful";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $canteen = Canteen::find($id);
        return "successful";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $canteen = Canteen::find($id);
        //return $news;
        $canteen->title = $request->get("title");
        $canteen->img = $request->get("img");
        $canteen->setImage($canteen, $request);
        //////////////////////
        $canteen->price = $request->get("price");
        $canteen->type = $request->get("type");

        $canteen->save();
        return "successful";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $canteen = Barter::find($id);
        $canteen->forceDelete();
        return "successful";
    }

}
