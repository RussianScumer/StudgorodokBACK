<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    public function setImage($canteen, $request): void
    {
        $currentDateTime = new DateTime('now');
        if ($canteen->img != "" && $canteen->img != "unchanged") {
            $imgToSave = $canteen->img;
            $canteen->img = env("APP_STORAGE_PATH") . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($canteen->img, base64_decode($imgToSave));
            $canteen->img = env("APP_URL") . "/api/storage/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        } else {
            $canteen->img = "";
        }
    }
    public static function deleteImage($canteen): void
    {
        $imgToDelete = $canteen->img;
        $imgToDelete = str_replace(env("APP_URL") . "/api/storage/", "", $imgToDelete);
        $imgToDelete = env("APP_STORAGE_PATH") . $imgToDelete;
        Storage::delete($imgToDelete);
    }
}

