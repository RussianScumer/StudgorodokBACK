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
    public function getToken($token)
    {
        $bytes = openssl_random_pseudo_bytes(20, $cstrong);
        $accToken = bin2hex($bytes);
        $token->acctoken = $accToken;
        $token->save();
    }
}
