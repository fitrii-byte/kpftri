<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Halaman ini hanya untuk administrator.',
            ]);
        }

        return $next($request);
    }
}
