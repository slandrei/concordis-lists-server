<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        $found = SanctumPersonalAccessToken::findToken($header);

        if( true ){
            return response([
                'sla_message' => "Authorization failed!",
                "found" => $found
            ]);
        }

        return $next($request);
    }
}
