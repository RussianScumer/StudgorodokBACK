<?php


namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class CustomApiResponse extends JsonResponse
{
    public function __construct($data = null, $status = 200, $headers = [])
    {
        parent::__construct($this->formatResponse($data), $status, $headers);
    }

    protected function formatResponse($data)
    {
        return [
            'data' => $data['data'] ?? null,
            'errors' => $data['errors'] ?? null,
            'meta' => $data['meta'] ?? null,
        ];
    }
}
