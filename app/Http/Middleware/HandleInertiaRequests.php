<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * O template raiz que é carregado na primeira visita à página
     * Geralmente aponta para 'resources/views/app.blade.php'
     */
    protected $rootView = 'app';

    /**
     * Determina a versão atual dos assets (JS/CSS).
     * Ajuda o Inertia a detectar quando o usuário precisa de um "hard refresh"
     * após um novo deploy no servidor.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define os dados (props) que são compartilhados por padrão com todos os componentes Vue
     * Tudo o que for colocado aqui estará disponível via '$page.props' no Frontend
    */
    public function share(Request $request): array
    {
        return [
            // Mantém os dados padrão do Inertia
            ...parent::share($request),

            // Compartilha os dados do usuário autenticado para o Layout e Navbar
            'auth' => [
                'user' => $request->user(),
            ],

            /**
             * SISTEMA DE MENSAGENS FLASH
             * Captura mensagens de sucesso/erro da sessão do Laravel e as envia para o Vue.
             * Usamos uma 'closure' (fn) para que o Laravel só busque na sessão se for necessário.
             */
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
        ];
    }
}