<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tokens;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\TokenAction;
use App\Models\OrioksUser;

class AuthOrioksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->json();
        $resultString = $user->get("username"). ':' .$user->get("password");
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
        $api_url2 = 'https://orioks.miet.ru/api/v1/student';
        if ($tokenOrioks === false) {
            echo 'Ошибка cURL: ' . curl_error($ch);
            return null;
        } else {
            $decoded_response = json_decode($tokenOrioks, true); // Парсинг JSON
            if (isset($decoded_response['token'])) {
                $headersNew = [
                    'Accept: application/json',
                    'Authorization: Bearer ' . $decoded_response['token'],
                    'User-Agent: TestApiAPP/0.1 Windows 10',
                ];

                $ch2 = curl_init($api_url2);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersNew);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch2);
                $decoded_response2 = json_decode($response, true);
                $orioksUser = New OrioksUser();
                $orioksUser->fullName = $decoded_response2['full_name'];
                $orioksUser->group = $decoded_response2['group'];
                if($user->has("token")){
                    $orioksUser->token = $user->get("token");
                }else{
                    $token = new Tokens();
                    $token->getToken($token);
                    $orioksUser->token = $token->acctoken;
                }
                curl_close($ch);
                return $orioksUser;
            } else {
                echo "The response does not contain a token field.";
            }
        }
        curl_close($ch);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
