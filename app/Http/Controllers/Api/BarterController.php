<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\Services\BarterService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BarterController extends Controller
{
    protected BarterService $barterService;

    public function __construct(BarterService $barterService)
    {
        $this->barterService = $barterService;
    }

    /**
     * Добавить новое объявление.
     */
    public function store(Request $request): ApiResource
    {
        $status = $this->barterService->add_new_ad($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 403);
        }

        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: не указаны все данные.", 400);
        }

        return new ApiResource($status, 'status', "", 201);
    }

    /**
     * Добавить картинку к объявлению.
     */
    public function store_image(Request $request): ApiResource
    {
        $status = $this->barterService->add_image_to_ad($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 403);
        }

        if ($status->status == 'max') {
            return new ApiResource(null, 'status', "Ошибка: максимальное количество картинок = 5.", 400);
        }

        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: не указаны данные.", 400);
        }

        return new ApiResource($status, 'status', "", 201);
    }

    /**
     * Вывести только одобренные объявления.
     */
    public function show_approved(Request $request): \Illuminate\Http\JsonResponse|ApiResource
    {
        $barter = $this->barterService->find_approved($request);

        if (!$barter) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 401);
        }

        if (isset(json_decode($barter)['data']) && empty(json_decode($barter)['data'])) {
            return new ApiResource(null, 'status', "Ошибка: объявления не найдены.", 404);
        }

        return $barter;
    }

    /**
     * Вывести только не одобренные объявления.
     */
    public function show_not_approved(Request $request): \Illuminate\Http\JsonResponse|ApiResource
    {
        $barter = $this->barterService->find_not_approved($request);

        if (!$barter) {
            return new ApiResource(null, 'status', "Ошибка: пользователь не авторизован.", 401);
        }

        if (isset(json_decode($barter)['data']) && empty(json_decode($barter)['data'])) {
            return new ApiResource(null, 'status', "Ошибка: объявления не найдены.", 404);
        }

        return $barter;
    }

    /**
     * Установить значение approved = true
     */
    public function approve(Request $request): ApiResource
    {
        $status = $this->barterService->approve_ad($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: объявление не найдено.", 404);
        }
        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: нет прав для одобрения объявления.", 403);
        }
        return new ApiResource($status, 'status', "", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): ApiResource
    {
        $status = $this->barterService->deny_ad($request);

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: объявление не найдено.", 404);
        }
        if ($status->status == 'fail') {
            return new ApiResource(null, 'status', "Ошибка: нет прав для отклонения объявления.", 403);
        }
        return new ApiResource($status, 'status', "", 204);
    }
}
