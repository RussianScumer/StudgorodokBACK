<?php

namespace App\Models;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barter extends Model
{
    use HasFactory;

    /**
     * @var mixed|true
     */

    public string $title;
    public string $comments;
    public string $contacts;
    public string $price;
    public string $stud_number;
    public string $img;
    public string $sender_name;
    public bool $approved;
    protected $table = "barter";

    protected $fillable = [
        'title',
        'comments',
        'contacts',
        'price',
        'img',
        'stud_number',
        'sender_name',
        'approved'
    ];
    public function setImage($barter, $request): void
    {
        $currentDateTime = new DateTime('now');
        if ($barter->img != "" && $barter->img != "unchanged") {
            $imgToSave = $barter->img;
            $barter->img = env("APP_STORAGE_PATH") . "/barter/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($barter->img, base64_decode($imgToSave));
            $barter->img = env("APP_URL") . "/api/storage/barter/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        } else {
            $barter->img = "";
        }
    }
    public static function deleteImage($canteen): void
    {
        $imgToDelete = $canteen->img;
        $imgToDelete = str_replace(env("APP_URL") . "/api/storage/barter/", env("APP_STORAGE_PATH") . "/barter/", $imgToDelete);
        unlink($imgToDelete);
    }
}
