<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;


class CheckProductOwner
{
    public function handle(Request $request, Closure $next)
    {
        $productId = $request->route('id');
        $userId = Auth::id();

        $product = Products::where('id', $productId)
            ->whereHas('seller', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();

        if (!$product || $product->seller->user_id !== $userId) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}