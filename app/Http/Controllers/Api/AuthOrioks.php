<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tokens;

class AuthOrioks extends Controller
{
    public function getToken()
    {
         $bytes = openssl_random_pseudo_bytes(20, $cstrong);
         $accToken = bin2hex($bytes);
         $token = new Tokens();
         $token->acctoken = $accToken;
         $token->save();
         echo $token;
}
}
