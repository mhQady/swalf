<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!(auth()->check() && auth()->user()->isBanned))
            return $next($request);

        return response()->json(
            [
                'status' => 403,
                'errors' => __('messages.Your account has been banned. For more info contact us')
            ],
            403
        );
    }
}
