<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait ApiKeyMe {
    public function ApiKeyMe(){
        $client = new Client();
        $headers = [
        'accept' => 'application/json',
        'content-type' => 'application/json',
        'Authorization' => 'Bearer '.$this->GenerateToken()
        ];
        $request = new Request('POST', 'https://gateway.staging.transferz.com/auth/api-keys/me', $headers);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody())->key;

    }
}
