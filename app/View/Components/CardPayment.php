<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardPayment extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $href = null,
        public string $method = 'GET',
        public string $buttonText = 'Comprar',
        public array $list = ['Pagamento rápido e seguro', 'Pagamento único e simples'],
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.card-component');
    }

    //chamada do componente: <x-card-payment buttonText="Pagar Agora" method="GET" />
    // ou <x-card-payment href="{{ route('paginaDePagamento') }}" buttonText="Ir para o Pagamento" />
}
