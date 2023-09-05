<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait GenerateToken {
    public function GenerateToken(){
        $client = new Client();
        $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        ];
        $body = '{
        "email": "contact@nordicxpresslimousine.dk",
        "password": "0OyznLqi4LoL"
        }';
        $request = new Request('POST', 'https://gateway.staging.transferz.com/auth/auth/generate-token', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody())->accessToken;
    }
}
