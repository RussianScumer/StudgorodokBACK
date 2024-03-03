<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */
    protected $table = "tokens";
    protected $fillable=[
       'acctoken'
    ];
}
