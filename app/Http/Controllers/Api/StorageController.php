<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;

class StorageController extends Controller
{
    public function getImage($filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filePath = storage_path('app/public/' . $filename); // путь к файлу в папке storage/app/public/

        return response()->file($filePath); // возвращаем запрашиваемый файл
    }
}
