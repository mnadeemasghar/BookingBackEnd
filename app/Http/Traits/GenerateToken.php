<?php
namespace App\Http\Traits;

trait GenerateToken
{
    use ApiCall;
    protected function generate_token(){
        $response = $this->api_call_post(
            'https://gateway.staging.transferz.com/auth/auth/generate-token',
            '{"email":"'.env("TRANSFERZ_EMAIL").'","password":"'.env('TRANSFERZ_PASSWORD').'"}'
        );

        return $response->accessToken;
    }
}
