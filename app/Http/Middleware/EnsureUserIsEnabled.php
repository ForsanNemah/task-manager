<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->enabled) {
            auth()->logout();


            dd("wwe");
            return redirect()->route('filament.auth.login')->withErrors([
                'email' => 'Ask the admin to enable your account.',
            ]);
        }

        return $next($request);
    }
}
