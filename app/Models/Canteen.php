<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canteen extends Model
{
    use HasFactory;

    protected $table = "canteens";
///	id	title	type	price	img	created_at	updated_at
    protected $fillable = [
        'title',
        'type',
        'price',
        'img'
    ];
    public function setImage($canteen, $request)
    {
        $currentDateTime = new DateTime('now');
        if ($canteen->img != "" && $canteen->img != "unchanged") {
            $imgToSave = $canteen->img;
            $canteen->img = "/home/a0872478/domains/a0872478.xsph.ru/laravel_project/storage/app/public/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($canteen->img, base64_decode($imgToSave));
            $canteen->img = "http://a0872478.xsph.ru/api/storage/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        } else {
            $canteen->img = "";
        }
    }
}

