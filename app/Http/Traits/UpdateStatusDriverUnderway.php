<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait UpdateStatusDriverUnderway {
    public function UpdateStatusDriverUnderway($id, $lat, $long){
        $client = new Client();
        $headers = [
        'X-API-Key' => $this->ApiKeyMe(),
        'accept' => 'application/json'
        ];
        $body = json_encode([
            "latitude" => $lat,
            "longitude"=> $long
        ]);
        $request = new Request(
            'PUT',
            'https://warpdrive.staging.transferz.com/transfercompanies/journeys/'.$id.'/status/driver-underway',
            [
                $body,
                $headers
            ]
        );
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody());
    }
}
