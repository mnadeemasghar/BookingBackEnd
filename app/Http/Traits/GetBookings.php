<?php
namespace App\Http\Traits;

trait GetBookings
{
    use ApiCall, GenerateToken;
    protected function get_bookings(){
        $response = $this->api_call_get_bearer(
            'https://gateway.staging.transferz.com/bookings/bookings?page=0&size=10',
            $this->generate_token()
        );

        return $response;
    }
}
