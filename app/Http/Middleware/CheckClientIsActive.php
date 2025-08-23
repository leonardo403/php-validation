<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckClientIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Sua conta está desativada.']);
        }
        return $next($request);
    }
}
