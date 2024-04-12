<?php

namespace App\Actions;

use App\Models\OrioksUser;
use App\Models\Tokens;

class OrioksAction
{
    protected $username = "username";

    protected $password = "password";

    static private $api_url = 'https://orioks.miet.ru/api/v1/auth';

    static private $api_url2 = 'https://orioks.miet.ru/api/v1/student';


    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getOrioksToken($username, $password)
    {
        $resultString = $this->$username . ':' . $this->$password;
        $encodedAuth = base64_encode($resultString);
        $headers = array(
            'Accept: application/json',
            'Authorization: Basic ' . $encodedAuth,
            'User-Agent: STUDGORODOKAPP/1.0.2 Android',
        );
        $ch = curl_init(OrioksAction::$api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tokenOrioks = curl_exec($ch);
        curl_close($ch);
        if ($tokenOrioks === false) {
            return response()->json(['error' => 'Ошибка: токен не найден.'], 500);
        } else {
            $this->getOrioksData($tokenOrioks);
        }
    }

    public function getOrioksData($tokenOrioks)
    {
        $decoded_response = json_decode($tokenOrioks, true);
        if (isset($decoded_response['token'])) {
            $headersNew = [
                'Accept: application/json',
                'Authorization: Bearer ' . $decoded_response['token'],
                'User-Agent: TestApiAPP/0.1 Windows 10',
            ];
            $ch2 = curl_init(OrioksAction::$api_url2);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersNew);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch2);
            curl_close($ch2);
            $decoded_response2 = json_decode($response, true);
            $orioksUser = new OrioksUser();
            $orioksUser->fullName = $decoded_response2['full_name'];
            $orioksUser->group = $decoded_response2['group'];
            if (isset($requestData['token']) && $requestData['token'] != null) {
                $orioksUser->token = $requestData['token'];
            } else {
                $token = new Tokens();
                $token->getToken($token);
                $orioksUser->token = $token->acctoken;
            }
            return $orioksUser;
        } else {
            return response()->json(['error' => 'Ошибка: не удалось получить токен.'], 500);
        }
    }
}
