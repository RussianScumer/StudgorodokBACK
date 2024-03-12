<?php

namespace App\Models;

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
        'sender_name'
    ];
}
