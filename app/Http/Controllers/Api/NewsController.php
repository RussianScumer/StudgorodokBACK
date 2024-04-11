<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PHPUnit\Exception;

class NewsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $news = new News();
            $news->title = $request->get("title");
            $news->content = $request->get("content");
            $news->img = $request->get("img");
            $news->setImage($news, $request);
            $news->save();
            return response()->json(['status' => 'success']);
        }
        catch (\Exception) {
            return response()->json(['status' => 'fail'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): string
    {
        if ($id == 0) {
            return News::latest()->take(10)->get();
        } else {
            return News::where('id', '<', (int)$id)->orderBy('id', 'desc')->take(10)->get();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $news = News::find($id);
            $news->title = $request->get("title");
            if ($request->get("img") != "unchanged") {
                if (!empty($news->img)) {
                    $news->deleteImage($news);
                }
                $news->img = $request->get("img");
                $news->setImage($news, $request);
            }
            $news->content = $request->get("content");
            $news->save();
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
        $news = News::find($id);
        if ($news) {
            if (!empty($news->img)) {
                $news->deleteImage($news);
            }
            $news->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'News successfully deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'News not found'], 404);
        }
    }
}
