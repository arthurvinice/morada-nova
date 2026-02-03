<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect('login')->with('warning', 'Você precisa estar logado.');
        }

        // Obtém o usuário autenticado
        $user = Auth::user();

        // Verifica se o usuário está ativo (supondo que há uma coluna 'is_active' no modelo User)
        if ($user->status !== 'active') {

            // Opcional: Desloga o usuário se estiver inativo
            Auth::logout();
            return redirect('/')->with('warning', 'Sua conta está inativa. Contate o suporte.');
        }

        // Registra a atividade do usuário no log
        Log::info('Usuário ativo acessou o sistema.', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ]);

        // Prossegue com a requisição
        return $next($request);
    }
}
