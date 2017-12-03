<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Console
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        setlocale(LC_ALL, 'fr_FR.utf-8'); // TOTO Trouver meilleur emplacement
        Carbon::setLocale('fr');

        return $next($request);
    }
}
