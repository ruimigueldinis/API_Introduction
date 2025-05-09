<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RecaptchaService
{
    /**
     * Verifica o token do reCAPTCHA com o Google
     *
     * @param Request $request
     * @return array ['success' => bool, 'errors' => array|null, 'score' => float|null]
     */
    private function verify(Request $request) : array
    {
        // Envia a requisição para a API do reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.google.recaptcha_secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        // Retorna a resposta JSON da API do Google
        return $response->json();
    }

    /**
     * Método para verificar o reCAPTCHA a partir de um objeto Request
     *
     * @param Request $request
     * @return string
     */
    public function verifyRequest(Request $request): string
    {
        // Chama o método 'verify' para verificar o reCAPTCHA
        $responseBody = $this->verify($request);

        // Se a verificação falhar, loga e retorna a mensagem de erro
        if (!($responseBody['success'] ?? false)) {
            logger()->warning('Falha no CAPTCHA', [
                'ip' => $request->ip(),
                'email' => $request->input('email'),
                'response' => $request->input('g-recaptcha-response'),
                'google' => $responseBody,
            ]);
            return false;
        }
        return true;
    }
}
