<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $table = "news";

    protected $fillable = [
        'title',
        'img',
        'content',
        'dateOfNews'
    ];
    public function setImage($news, $request)
    {
        $currentDateTime = new DateTime('now');
        if ($news->img != "" && $news->img != "unchanged") {
            $imgToSave = $news->img;
            $news->img = "/home/a0872478/domains/a0872478.xsph.ru/laravel_project/storage/app/public/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($news->img, base64_decode($imgToSave));
            $news->img = "http://a0872478.xsph.ru/api/storage/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        } else {
            $news->img = "";
        }
    }
    public function deleteImage($news)
    {
        $imgToDelete = $news->img;
        $imgToDelete = str_replace("http://a0872478.xsph.ru/api/storage/", "", $imgToDelete);
        $imgToDelete = "/home/a0872478/domains/a0872478.xsph.ru/laravel_project/storage/app/public/" . $imgToDelete;
        Storage::delete($imgToDelete);
    }
}
