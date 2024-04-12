<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = "news";

    protected $fillable = [
        'title',
        'content',
        'img'
    ];
    protected string $title;
    protected string $content;
    public function setImage($news, $request): void
    {
        $currentDateTime = new DateTime('now');
        if ($news->img != "" && $news->img != "unchanged") {
            $imgToSave = $news->img;
            $news->img = env("APP_STORAGE_PATH") . "/news/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($news->img, base64_decode($imgToSave));
            $news->img = env("APP_URL") . "/api/storage/news/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        } else {
            $news->img = "";
        }
    }
    public static function deleteImage($news): void
    {
        $imgToDelete = $news->img;
        $imgToDelete = str_replace(env("APP_URL") . "/api/storage/news/", env("APP_STORAGE_PATH") . "/news/", $imgToDelete);
        unlink($imgToDelete);
    }
}
