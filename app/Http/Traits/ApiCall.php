<?php
namespace App\Http\Traits;

trait ApiCall
{
    protected function api_call_post($url, $body){

        $client = new \GuzzleHttp\Client();

        $response = $client->request("POST", $url, [
        'body' => $body,
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
        ]);

        return json_decode($response->getBody());
    }

    protected function api_call_get_bearer($url, $token){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $url, [
        'headers' => [
            'accept' => 'application/json',
            'authorization' => "Bearer ".$token,
        ],
        ]);

        return json_decode($response->getBody());
    }
}
