<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsBlocked
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
        if (auth()->user()->bloqueado)
            return redirect()->route('verification')->with(['verification' => ['title'=>'Login', 'message'=>'A sua entrada está bloqueada!']]);

        return $next($request);
    }
}
