<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait DeclineOffer {
    public function DeclineOffer($id, $reason, $description){
        $client = new Client();
        $headers = [
        'X-API-Key' => $this->ApiKeyMe(),
        'accept' => 'application/json'
        ];
        $body = json_encode([
            "reason" => $reason,
            "description" => $description
        ]);
        $request = new Request(
            'POST',
            'https://warpdrive.staging.transferz.com/transfercompanies/offers/'.$id.'/decline',
            [
                $body,
                $headers
            ]
        );
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody());
    }
}
