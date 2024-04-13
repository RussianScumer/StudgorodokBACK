<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    /**
     * @var mixed|string
     */
    protected $table = "users";
    protected $fillable = [
        'user_id',
        'acc_token',
        'is_admin'
    ];

    private string $acc_token;
    private string $user_id;
    private int $is_admin;
    private string $full_name;
    private string $group;

    public function setToken(): string
    {
        $bytes = openssl_random_pseudo_bytes(20, $cstrong);
        return bin2hex($bytes);
    }
}
