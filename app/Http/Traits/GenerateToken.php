<?php

namespace App\Http\Traits;

use App\Models\Transferz;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait GenerateToken {
    public function GenerateToken(){
        $TRANSFERZ_EMAIL = Transferz::where('key',"TRANSFERZ_EMAIL")->first();
        $TRANSFERZ_PASSWORD = Transferz::where('key',"TRANSFERZ_PASSWORD")->first();
        $client = new Client();
        $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        ];
        $body = '{
        "email": "'.$TRANSFERZ_EMAIL->value.'",
        "password": "'.$TRANSFERZ_PASSWORD->value.'"
        }';
        $request = new Request('POST', 'https://gateway.staging.transferz.com/auth/auth/generate-token', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody())->accessToken;
    }
}
