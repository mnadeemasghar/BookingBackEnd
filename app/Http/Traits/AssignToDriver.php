<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait AssignToDriver {
    public function AssignToDriver($id, $name, $phone, $notifyBySms){
        $client = new Client();
        $headers = [
        'X-API-Key' => $this->ApiKeyMe(),
        'accept' => 'application/json'
        ];
        $body = json_encode([
            "name" => $name,
            "phoneNumber" => $phone,
            "notifyBySms" => $notifyBySms
        ]);
        $request = new Request(
            'POST',
            'https://warpdrive.staging.transferz.com/transfercompanies/journeys/'.$id.'/assign-driver',
            [
                $body,
                $headers
            ]
        );
        $res = $client->sendAsync($request)->wait();
        return json_decode($res->getBody());
    }
}
