<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    protected string $data_type;
    protected string $error_message;
    protected $model;
    protected int $code;

    public function __construct($resource, $data_type, $error_message, $code)
    {
        parent::__construct($resource);
        $this->data_type = $data_type;
        $this->error_message = $error_message;
        $this->code = $code;
        $this->model = $resource;
    }
    /**
     * Создание ресурса.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!empty($this->error_message)) {
            return [
                'data' => null,
                'error' => $this->formatError()
            ];
        }

        return [
            'data' => $this->formatData(),
            'meta' => [
                'code' => $this->code
            ]
        ];
    }

    protected function formatError(): ?array
    {
        return [
            'error_message' => $this->error_message,
            'code' => $this->code
        ];
    }

    protected function formatData(): ?array
    {
        // В зависимости от условий формируется нужная структура данных
        return match ($this->data_type) {
            'status' => $this->formatStatusData(),
            'users' => $this->formatUsersData(),
            'news' => $this->formatNewsData(),
            'canteen' => $this->formatCanteenData(),
            default => null
        };
    }

    protected function formatUsersData(): array
    {
        if (!$this->model) {
            return [];
        }
        // Data для User
        return [
            'acc_token' => $this->model->acc_token,
            'is_admin' => $this->model->is_admin,
            'full_name' => $this->model->full_name,
            'group' => $this->model->group
        ];
    }

    protected function formatNewsData(): array
    {
        if (!$this->model) {
            return [];
        }
        // Data для News
        if ($this->model instanceof \Illuminate\Support\Collection) {
            $formattedData = [];
            foreach ($this->model as $item) {
                $formattedData[] = [
                    'title' => $item->title,
                    'content' => $item->content,
                    'img' => $item->img,
                    'created_at' => $item->created_at
                ];
            }
            return $formattedData;
        }
        else {
            return [
                'title' => $this->model->title,
                'content' => $this->model->content,
                'img' => $this->model->img,
                'created_at' => $this->model->created_at
            ];
        }
    }

    private function formatStatusData(): array
    {
        if (!$this->model) {
            return [];
        }
        // Data для Status
        return [
            'status' => $this->model->status
        ];
    }

    private function formatCanteenData(): array
    {
        if (!$this->model) {
            return [];
        }
        // Data для Canteen
        if ($this->model instanceof \Illuminate\Support\Collection) {
            $formattedData = [];
            foreach ($this->model as $item) {
                $formattedData[] = [
                    'title' => $item->title,
                    'type' => $item->type,
                    'price' => $item->price,
                    'img' => $item->img
                ];
            }
            return $formattedData;
        }
        else {
            return [
                'title' => $this->model->title,
                'type' => $this->model->type,
                'price' => $this->model->price,
                'img' => $this->model->img
            ];
        }
    }
}
