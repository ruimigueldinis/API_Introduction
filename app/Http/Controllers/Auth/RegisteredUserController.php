<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Facades\Http;
use App\Services\RecaptchaService;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $recaptchaService = new RecaptchaService();
        $recaptchaResult = $recaptchaService->verifyRequest($request);

        if ($recaptchaResult == false) {
            return back()->withErrors(['captcha' => 'Falha na verificação do ReCAPTCHA. Tente novamente.']);
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // //Ponto 4 do fluxo 🔝: validação dos dados do reCAPTCHA (ADICIONANDO À FUNÇÃO QUE JÁ EXISTE)
        // $responseBody = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => config('services.google.recaptcha_secret_key'), // chave secreta
        //     'response' => $request->input('g-recaptcha-response'), // valor enviado pelo frontend
        //     'remoteip' => $request->ip(), // opcional, mas recomendado
        // ]);

        // //Ponto 6 do fluxo: recebe e interpreta a resposta da API do Google
        // $result = $responseBody->json();

        // if (!($result['success'] ?? false)) {
        //     //neste ponto, podemos "logar" para um debug mais detalhado.
        //     //Poderíamos implementar: logger()->error('reCAPTCHA falhou', $result);
        //     //Ou uma versão mais "completa" com IP, e-mail e timestamp para análise posterior ou para bloquear IPs abusivos.
        //     logger()->warning('Falha no CAPTCHA', [
        //         'ip' => $request->ip(),
        //         'email' => $request->input('email'),
        //         'response' => $request->input('g-recaptcha-response'),
        //         'google' => $responseBody,
        //     ]);
        //     return back()->withErrors(['captcha' => 'Falha na verificação do reCAPTCHA.']);
        // }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
