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
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $news = new News();
        $news->title = $request->get("title");
        $news->content = $request->get("content");
        $news->img = $request->get("img");
        $news->setImage($news, $request);
        $currentDateTime = new DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d');
        $news->dateOfNews = $currentDate;
        $news->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): string
    {
        $news = News::find($id);
        return "successful";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $news = News::find($id);
        $news->title = $request->get("title");
        if ($request->get("img") != "unchanged") {
            $news->img = $request->get("img");
        }
        $news->setImage($news, $request);
        $currentDateTime = new DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d');
        $news->dateOfNews = $currentDate;
        $news->content = $request->get("content");
        $news->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $news = News::find($id);
        if ($news) {
            $news->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'News successfully deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'News not found'], 404);
        }
    }
}
