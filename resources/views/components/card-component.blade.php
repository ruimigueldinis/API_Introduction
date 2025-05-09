<section class="flex items-center justify-center mt-10 pb-10">
    <div class="p-2 sm:px-10 flex flex-col justify-center items-center text-base h-100vh mx-auto" id="pricing">
        <div class="isolate mx-auto grid max-w-md grid-cols-1 gap-2 lg:mx-0 lg:max-w-none">
            <div class="ring-2 ring-blue-600 rounded-3xl p-4 xl:p-10">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 id="tier-extended" class="text-blue-600 text-2xl font-semibold leading-8">Comprar</h3>
                    <p class="rounded-full bg-blue-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-blue-600">
                        Mais popular
                    </p>
                </div>
                <p class="mt-4 text-base leading-6 text-gray-600">Pagar com Cartão de teste oferecido pelo PayPal</p>
                <p class="mt-6 flex items-center justify-center mb-4 text-center">
                    <span class="line-through text-2xl font-sans text-gray-500/70">10€</span>
                    <span class="text-5xl font-bold tracking-tight text-gray-900">1€</span>
                </p>

                @if ($href)
                    <a href="{{ $href }}"
                        class="text-blue-600 ring-1 ring-inset ring-blue-200 hover:ring-blue-300 mt-6 block rounded-md py-2 px-3 text-center text-base font-medium leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        {{ $buttonText }}
                    </a>
                @else
                    <form action="{{ route('transaction.process') }}" method="{{ $method }}">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ $buttonText }}
                        </button>
                    </form>
                @endif

 {{--  Refatoração para Mais reutilização: @foreach (['Pagamento seguro', 'Pagamento único', 'Pagamento simples'] as $item)--}}
                 <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
                    @foreach ($list as $item)
                        <li class="flex gap-x-3 text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                class="h-6 w-5 flex-none text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
