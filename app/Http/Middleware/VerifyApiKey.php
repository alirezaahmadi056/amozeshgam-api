<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty($request->header("x-api-key"))){
            if($request->header("x-api-key") == env("X_API_KEY")){
                return $next($request);
            }else{
                return abort(403,"Api Key Is Invalid");
            }
        }else{
            return abort(500,"Undifind Api Key");
        }
    }
}
