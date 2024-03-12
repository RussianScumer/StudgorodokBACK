<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use DateTime;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return News::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $news = new News();
        $news->title = $request->get("title");
        $news->img = $request->get("img");
        $news->setImage($news, $request);
        $currentDateTime = new DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d');
        $news->dateOfNews = $currentDate;
        $news->content = $request->get("content");
        $news->save();
        return "successful";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);
        return "successful";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::find($id);
        //return $news;
        $news->title = $request->get("title");
        $news->img = $request->get("img");
        $news->setImage($news, $request);
        $currentDateTime = new DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d');
        $news->dateOfNews = $currentDate;
        $news->content = $request->get("content");
        $news->save();
        return "successful";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);
        $news->forceDelete();
        return "successful";
    }
}
