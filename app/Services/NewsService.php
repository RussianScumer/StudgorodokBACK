<?php

namespace App\Services;

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
            return null;
        }
    }

    public function show_news($request)
    {
        if (User::where("acc_token", $request->input('token'))->exists()) {
            $id = $request->input('id');
            if ($id == 0) {
                return News::latest()->take(10)->get();
            } else {
                return News::where('id', '<', (int)$id)->orderBy('id', 'desc')->take(10)->get();
            }
        }
        else {
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
            return null;
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
                    $status->status = "fail";
                    return $status;
                }
            }
            else {
                return null;
            }
        }
        catch (\Exception) {
            return null;
        }
    }
}
