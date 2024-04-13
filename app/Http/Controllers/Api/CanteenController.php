<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\Services\CanteenService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CanteenController extends Controller
{
    protected CanteenService $canteenService;

    public function __construct(CanteenService $canteenService)
    {
        $this->canteenService = $canteenService;
    }

    /**
     * Добавить блюдо.
     */
    public function store(Request $request): ApiResource
    {
        $status = $this->canteenService->add_dish($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: нет прав для добавления блюда.", 403);
        }

        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: не указаны все данные.", 400);
        }

        return new ApiResource($status, 'status', "", 201);
    }

    /**
     * Вывести всё меню.
     */
    public function show(Request $request): ApiResource
    {
        $canteen = $this->canteenService->show_menu($request);

        if (!$canteen) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 401);
        }
        return new ApiResource($canteen, 'canteen', "", 200);
    }

    /**
     * Обновить блюдо.
     */
    public function update(Request $request): ApiResource
    {
        $status = $this->canteenService->update_dish($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: нет прав для обновления блюда.", 403);
        }

        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: не указаны все данные.", 400);
        }

        return new ApiResource($status, 'status', "", 200);
    }

    /**
     * Удалить блюдо.
     */
    public function destroy(Request $request): ApiResource
    {
        $status = $this->canteenService->delete_dish($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: блюдо не найдено.", 404);
        }

        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: нет прав для удаления блюда.", 403);
        }

        return new ApiResource($status, 'status', "", 204);
    }
}
