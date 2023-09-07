<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait AcceptOffer {
    public function AcceptOffer($id, $meetingPointId, $type){
        $client = new Client();
        $headers = [
        'X-API-Key' => $this->ApiKeyMe(),
        'accept' => 'application/json'
        ];
        $body = json_encode([
            "meetingPointId" => $meetingPointId,
            "type" => $type
        ]);
        $request = new Request(
            'POST',
            'https://warpdrive.staging.transferz.com/transfercompanies/offers/'.$id.'/accept',
            [
                $body,
                $headers
            ]
        );
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody());
    }
}
