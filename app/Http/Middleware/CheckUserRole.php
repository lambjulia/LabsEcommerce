<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{

    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = $request->user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('/')->with('denied', '402');

    }
}
