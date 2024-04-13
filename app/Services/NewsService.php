<?php

namespace App\Services;

use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\Status;
use App\Models\User;

class NewsService
{
    public function add_news($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $news = new News();
                $news->title = $request->get("title");
                $news->content = $request->get("content");
                $news->img = $request->get("img");
                $news->setImage($news, $request);
                $news->save();
                $status->status = "success";
                return $status;
            }
            else {
                return null;
            }
        }
        catch (\Exception)
        {
            $status->status = 'fail';
            return $status;
        }
    }

    public function show_news($request): ?\Illuminate\Http\JsonResponse
    {
        if (User::where("acc_token", $request->input('token'))->exists()) {
            $paginator = News::orderBy("id", "desc")->cursorPaginate(10);
            $array = [];
            foreach ($paginator->items() as $item) {
                $array[] = new NewsResource($item);
            }
            return response()->json([
                "data" => $array,
                "meta" => [
                    "next_url" => $paginator->nextPageUrl(),
                    "code" => 200
                    ]
            ]);
        } else {
            return null;
        }
    }

    public function update_news($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $news = News::find($id);
                if ($news == null) {
                    throw new \Exception('Объект не найден.');
                }
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
                $status->status = "success";
                return $status;
            }
            else {
                return null;
            }
        }
        catch (\Exception) {
            $status->status = 'fail';
            return $status;
        }
    }

    public function delete_news($request): ?Status
    {
        $status = new Status();
        try {
            if (User::where("acc_token", $request->input('token'))->value('is_admin')) {
                $id = $request->input('id');
                $news = News::find($id);
                if ($news) {
                    if (!empty($news->img)) {
                        $news->deleteImage($news);
                    }
                    $news->forceDelete();
                    $status->status = "success";
                    return $status;
                } else {
                    return null;
                }
            }
            else {
                $status->status = 'fail';
                return $status;
            }
        }
        catch (\Exception) {
            return null;
        }
    }
}
