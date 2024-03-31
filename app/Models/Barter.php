<?php

namespace App\Models;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barter extends Model
{
    use HasFactory;

    protected $table = "barters";

    protected $fillable = [
        'title',
        'comments',
        'contacts',
        'price',
        'img',
        'stud_number',
        'sender_name',
        'suggested'
    ];
    public function setImage($barter, $request)
    {
        $currentDateTime = new DateTime('now');
        if ($barter->img != "" && $barter->img != "unchanged") {
            $imgToSave = $barter->img;
            $barter->img = "/home/a0872478/domains/a0872478.xsph.ru/barter_img/" . $currentDateTime->format('Y-m-d_H-i-s') . $request->get("extension");
            file_put_contents($barter->img, base64_decode($imgToSave));
        } else {
            $barter->img = "";
        }
    }
}
