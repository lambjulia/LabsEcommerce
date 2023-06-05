<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifySellerApproval
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'seller') {
                if (Auth::user()->seller->status === 'approved') {
                    return $next($request);
                }
            }
        }

        return redirect('/')->with('denied', '402');
    }
}