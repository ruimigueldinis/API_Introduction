<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeira dos Países</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[600px] text-center">

        <h1 class="text-2xl font-bold mb-4">Buscar Bandeira</h1>
        <form method="POST" action="/form-bandeira" class="space-y-4">
            @csrf
            <div class="flex items-center space-x-3">
                <label for="pais" class="w-1/3 text-gray-700">Código do país:</label>
                <input type="text" name="pais" id="pais" placeholder="Ex: PT" required
                    class="w-1/3 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="w-1/3 items-center">

                    @unless (empty($codigo))
                        <img src="https://flagsapi.com/{{ $codigo }}/shiny/64.png"
                            alt="Bandeira de {{ $codigo }}"
                            onerror="this.style.display='none'; document.getElementById('erro-bandeira').style.display = 'block';">
                        <p id="erro-bandeira" class="w-full text-red-500 mt-2 text-center" style="display: none;">
                            Bandeira "{{ $codigo }}" não encontrada.
                        </p>
                    @endunless
                </div>
            </div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <div class="flex flex-col items-center justify-center mt-4">
        <div class="g-recaptcha" data-sitekey="{{ config('services.google.recaptcha_site_key') }}"></div>
        @error('captcha')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-2 text-sm flex items-center"
                role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0-11a1.5 1.5 0 00-1.5 1.5v5a1.5 1.5 0 003 0v-5A1.5 1.5 0 0010 4z" />
                </svg>
                <span>{{ $message }}</span>
            </div>
        @enderror
    </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                Buscar
            </button>
        </form>
    </div>
</body>

</html>
