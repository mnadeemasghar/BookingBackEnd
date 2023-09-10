<?php
namespace App\Http\Traits;

trait GetJourney
{
    use ApiCall, GenerateToken;
    protected function GetJourney($id){
        $response = $this->api_call_get_bearer(
            'https://warpdrive.staging.transferz.com/transfercompanies/journeys/'.$id,
            $this->generate_token()
        );

        return $response;
    }
}
