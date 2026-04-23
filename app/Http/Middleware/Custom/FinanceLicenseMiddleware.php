<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FinanceLicenseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
