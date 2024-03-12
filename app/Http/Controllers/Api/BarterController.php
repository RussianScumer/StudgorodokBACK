<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barter;
use Illuminate\Http\Request;

class BarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Barter::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //'title+',
    //'comments',
    //'contacts+',
    //'price+',
    //'img+',
    //'stud_number+',
    //'sender_name+'
    public function store(Request $request)
    {
        $barter = new Barter();
        $barter->title = $request->get("title");
        $barter->img = $request->get("img");
        $barter->setImage($barter, $request);
       //////////////////////
        $barter->comments = $request->get("comments");
        $barter->contacts = $request->get("contacts");
        $barter->price = $request->get("price");
        $barter->stud_number = $request->get("stud_number");
        $barter->sender_name = $request->get("sender_name");
        $barter->save();
        return "successful";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barter = Barter::find($id);
        return "successful";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barter = Barter::find($id);
        //return $news;
        $barter->title = $request->get("title");
        $barter->img = $request->get("img");
        $barter->setImage($barter, $request);
        //////////////////////
        $barter->comments = $request->get("contacts");
        $barter->contacts = $request->get("contacts");
        $barter->price = $request->get("price");
        $barter->stud_number = $request->get("stud_number");
        $barter->sender_name = $request->get("sender_name");
        $barter->save();
        return "successful";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barter = Barter::find($id);
        $barter->forceDelete();
        return "successful";
    }
}
