<?php

namespace App\Http\Traits;

use App\Models\Transferz;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait GenerateToken {
    public function GenerateToken(){
        $TRANSFERZ_EMAIL = Transferz::where('key',"TRANSFERZ_EMAIL")->first();
        if($TRANSFERZ_EMAIL == null){
            Transferz::create([
                "key" => "TRANSFERZ_EMAIL",
                "value" => env('TRANSFERZ_EMAIL')
            ]);
        }

        $TRANSFERZ_PASSWORD = Transferz::where('key',"TRANSFERZ_PASSWORD")->first();
        if($TRANSFERZ_PASSWORD == null){
            Transferz::create([
                "key" => "TRANSFERZ_PASSWORD",
                "value" => env('TRANSFERZ_PASSWORD')
            ]);
        }

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
