<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }
    /**
     * Добавить новость.
     */
    public function store(Request $request): ApiResource
    {
        $status = $this->newsService->add_news($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: нет прав для добавления новости.", 403);
        }
        return new ApiResource($status, 'status', "", 201);
    }

    /**
     * Вывести 10 новостей.
     */
    public function show(Request $request)
    {
        $news = $this->newsService->show_news($request);

        if (!$news) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 401);
        }
        return $news;
    }

    /**
     * Обновить новость.
     */
    public function update(Request $request): ApiResource
    {
        $status = $this->newsService->update_news($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: нет прав для обновления новости.", 403);
        }
        return new ApiResource($status, 'status', "", 200);
    }

    /**
     * Удалить новость.
     */
    public function destroy(Request $request): ApiResource
    {
        $status = $this->newsService->delete_news($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: нет прав для удаления новости.", 403);
        }
        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: новость не найдена.", 404);
        }
        return new ApiResource($status, 'status', "", 204);
    }
}
