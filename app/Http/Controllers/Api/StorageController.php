<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function getImage($filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filePath = storage_path('app/public/' . $filename); // путь к файлу в папке storage/app/public/

        /*if (!Storage::exists($filePath)) {
            abort(404); // если файл не найден, возвращаем ошибку 404
        }*/

        return response()->file($filePath); // возвращаем запрашиваемый файл
    }
}
