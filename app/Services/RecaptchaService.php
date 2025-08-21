<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    private string $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.recaptcha.secret_key');
    }

    public function verify(string $token): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $this->secretKey,
            'response' => $token,
        ]);

        $result = $response->json();
        return $result['success'] ?? false;
    }
}
