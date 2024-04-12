<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Вход в приложение.
     */
    public function login(Request $request): ApiResource
    {
        $tokenOrioks = $this->authService->getToken($request->input('username'), $request->input('password'));

        if (!$tokenOrioks) {
            return new ApiResource(null, 'users', 'Ошибка: токен не найден.', 404);
        }

        $user = $this->authService->getUserInfo($request->input('username'), $tokenOrioks, $request->input('token'));

        if (!$user) {
            return new ApiResource(null, 'users', 'Ошибка: не удалось получить информацию о пользователе.', 401);
        }

        return new ApiResource($user, 'users', "", 200);
    }

    /**
     * Выйти из приложения.
     */
    public function quit(Request $request): ApiResource
    {
        $status = $this->authService->deleteToken($request->input('token'));

        if (!$status) {
            return new ApiResource(null, 'status', "Ошибка: не удалось удалить токен.", 400);
        }
        return new ApiResource($status, 'status', "", 204);
    }
}
