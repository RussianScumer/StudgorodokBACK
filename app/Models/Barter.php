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
    protected string $title;
    protected string $comments;
    protected string $contacts;
    protected string $price;
    protected string $stud_number;
    protected string $sender_name;
    protected bool $approved;
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
