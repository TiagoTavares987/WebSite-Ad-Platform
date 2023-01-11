<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_admin) // verifica se é admin e se nao for nao vai ter acesso a funcionalidades do admin atraves do url
            return redirect()->route('verification')->with(['verification' => ['title'=>'Administrador', 'message'=>'Voçê não tem direitos de administrador!']]);

        return $next($request);
    }
}
