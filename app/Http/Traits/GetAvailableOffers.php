<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait GetAvailableOffers {
    public function GetAvailableOffers(){
        $client = new Client();
        $headers = [
        'X-API-Key' => $this->ApiKeyMe(),
        'accept' => 'application/json'
        ];
        $request = new Request('GET', 'https://warpdrive.staging.transferz.com/transfercompanies/offers/available/all', $headers);
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody());


    }
}
