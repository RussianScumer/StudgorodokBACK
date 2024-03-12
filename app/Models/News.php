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
        'img',
        'content',
        'dateOfNews'
    ];
    public function setImage($news, $request)
    {
        $currentDateTime = new DateTime('now');
        if ($news->img != "" && $news->img != "unchanged") {
            $imgToSave = $news->img;
            $news->img = "/home/a0872478/domains/a0872478.xsph.ru/news_img/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($news->img, base64_decode($imgToSave));
        } else {
            $news->img = "";
        }
    }
}
