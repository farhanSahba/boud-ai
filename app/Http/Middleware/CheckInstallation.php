<?php

namespace App\Http\Middleware;

use App\Helpers\Classes\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            abort_if(! Helper::dbConnectionStatus(), 503, 'Application database is not ready.');

            static $hasUsersTable;
            if ($hasUsersTable === null) {
                $hasUsersTable = Schema::hasTable('users');
            }

            abort_if(! $hasUsersTable, 503, 'Application database is not ready.');

            return $next($request);
        } catch (PDOException $e) {
            abort(503, 'Application database is not ready.');
        }
    }
}
