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
        'description',
        'contacts',
        'price',
        'img',
        'stud_number',
        'sender_name',
        'approved'
    ];
    protected string $title;
    protected string $description;
    protected string $contacts;
    protected string $price;
    protected string $stud_number;
    protected string $sender_name;
    protected bool $approved;
    public function setImage($barter, $request): void
    {
        $currentDateTime = new DateTime('now');
        $link = $request->input("img");
        $imageToSave = $link;
        $link = env("APP_STORAGE_PATH") . "/barter/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        file_put_contents($link, base64_decode($imageToSave));
        $link = env("APP_URL") . "/api/storage/barter/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
        if (empty($barter->img)) {
            $barter->img = $link;
        }
        else {
            $barter->img = $barter->img . " " . $link;
        }
    }
    public static function deleteImage($barter): void
    {
        if (count(explode(" ", $barter->img)) > 0) {
            $links = explode(" ", $barter->img);
            foreach ($links as $imgToDelete) {
                $imgToDelete = str_replace(env("APP_URL") . "/api/storage/barter/", env("APP_STORAGE_PATH") . "/barter/", $imgToDelete);
                unlink($imgToDelete);
            }
        }
        else {
            $imgToDelete = $barter->img;
            $imgToDelete = str_replace(env("APP_URL") . "/api/storage/barter/", env("APP_STORAGE_PATH") . "/barter/", $imgToDelete);
            unlink($imgToDelete);
        }
    }
}
