<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Msg91OtpService
{
    protected string $baseUrl = 'https://control.msg91.com/api/v5/widget';

    /**
     * Verify the access token from MSG91 OTP widget
     *
     * @param string $authKey
     * @param string $accessToken
     * @return array|null
     */
    public function verifyAccessToken(string $authKey, string $accessToken): ?array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->baseUrl . '/verifyAccessToken', [
            'authkey' => $authKey,
            'access-token' => $accessToken,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        // Optional: log or throw exception
        return null;
    }
}
