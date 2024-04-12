<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Status;
use App\Models\User;

class AuthService
{
    public function getToken($username, $password): bool|string
    {
        $resultString = $username. ':' .$password;
        $api_url = 'https://orioks.miet.ru/api/v1/auth';
        $encoded_auth = base64_encode($resultString);
        $headers = array(
            'Accept: application/json',
            'Authorization: Basic ' . $encoded_auth,
            'User-Agent: STUDGORODOKAPP/1.0.2 Android',
        );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tokenOrioks = curl_exec($ch);
        curl_close($ch);
        return $tokenOrioks;
    }

    public function getUserInfo($username, $tokenOrioks, $token): ?User
    {
        $api_url2 = 'https://orioks.miet.ru/api/v1/student';
        $decoded_tokenOrioks = json_decode($tokenOrioks, true); // Парсинг JSON
        if (isset($decoded_tokenOrioks['token'])) {
            $headersNew = [
                'Accept: application/json',
                'Authorization: Bearer ' . $decoded_tokenOrioks['token'],
                'User-Agent: TestApiAPP/0.1 Windows 10',
            ];

            $ch = curl_init($api_url2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headersNew);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $decoded_response = json_decode($response, true);
            $user = new User();
            if (isset($token) && $token != null) {
                if (User::where("acc_token", $token)->exists()) {
                    $user->user_id = $username;
                    $user->acc_token = $token;
                    $user->is_admin = User::where("acc_token", $user->acc_token)->value('is_admin');
                }
                else {
                    return null;
                }
            } else {
                $user->acc_token = $user->setToken();
                $user->is_admin = Admin::where("users", $username)->exists();
                $user->user_id = $username;
                $user->save();
            }
            $user->full_name = $decoded_response['full_name'];
            $user->group = $decoded_response['group'];
            return $user;
        } else {
            return null;
        }
    }
    public function deleteToken($token): ?Status
    {
        $status = new Status();
        try {
            User::where("acc_token", $token)->delete();
            $status->status = "success";
            $status->code = "200";
            return $status;
        }
        catch (\Exception)
        {
            return null;
        }
    }
}
