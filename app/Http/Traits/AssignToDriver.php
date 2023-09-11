<?php

namespace App\Http\Traits;

use App\Models\Booking;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait AssignToDriver {
    public function AssignToDriver($id, $name, $phone, $notifyBySms, $price){
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

        // check if booking_id exist
        $booking = Booking::where("booking_id",$id)->first();
        $driver = User::where("phone_no", $phone)->first();
        if($booking){

            $booking->update([
                "driver_id" => $driver->id,
                "transferz" => true,
                "price_driver" => $price,
                "status" => "assigned"
            ]);
        }
        else{
            Booking::create([
                "booking_id" => $id,
                "driver_id" => $driver->id,
                "transferz" => true,
                "price_driver" => $price,
                "status" => "assigned"
            ]);
        }
        return json_decode($res->getBody());
    }
}
